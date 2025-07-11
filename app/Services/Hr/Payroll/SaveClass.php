<?php

namespace App\Services\Hr\Payroll;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Dtr;
use App\Models\User;
use App\Models\Payroll;
use App\Models\PayrollCycle;
use App\Models\PayrollCutoff;
use App\Models\PayrollDeduction;
use App\Models\UserDeduction;
use App\Models\UserOrganization;
use App\Http\Resources\Hr\DeductionResource;
use App\Http\Resources\Hr\PayrollResource;
use App\Http\Resources\Hr\CycleResource;

class SaveClass
{
    public function cycle($request){
        $cycle = PayrollCycle::where('month',$request->month)->where('year',$request->year)->where('is_regular',$request->is_regular)->first();
        if($cycle){
            $data = PayrollCutoff::create(
                array_merge($request->all(), [
                    'code' => $this->generateCode2(),
                    'user_id' => \Auth::user()->id,
                    'cycle_id' => $cycle->id,
                    'status_id' => 17
                ])
            );
        }else{
            $data = PayrollCycle::create(array_merge($request->all(), [
                'code' => $this->generateCode(),
                'user_id' => \Auth::user()->id
            ]));
            $data->cutoffs()->create(
                array_merge($request->all(), [
                    'code' => $this->generateCode2(),
                    'user_id' => \Auth::user()->id,
                    'status_id' => 17
                ])
            );
        }
        return [
            'data' => new CycleResource($data),
            'message' => 'Cycle creation was successful!', 
            'info' => "You've successfully created a new cycle."
        ];
    }

    public function remove($request){
        $payroll = Payroll::findOrFail($request->id); // or use route param
        $payroll->delete();

        return [
            'data' => '',
            'message' => 'Payroll was remove successful!', 
            'info' => "You've successfully removed a payroll."
        ];
    }

    public function deduction($request){
        $data = Payroll::where('id',$request->payroll_id)->first();
        $deduction = $data->deductions()->create($request->all());
        if($deduction){
            $data->deduction = floatval(str_replace(['₱', ','], '', $data->deduction)) + floatval(str_replace(['₱', ','], '', $request->amount));
            $data->netpay = floatval(str_replace(['₱', ','], '',$data->gross)) - floatval(str_replace(['₱', ','], '', $data->deduction));
            $data->save();
        }
        $data = Payroll::with('deductions.deduction')
        ->with('user.profile:id,user_id,firstname,middlename,lastname,suffix')
        ->with('user:id,username','user.organization:id,user_id,position_id,salary_id,type_id','user.organization.type:id,name','user.organization.position:id,name','user.organization.salary:id,grade,amount')
        ->where('id',$request->payroll_id)->first();
        return [
            'data' => new PayrollResource($data),
            'message' => 'Cycle creation was successful!', 
            'info' => "You've successfully created a new cycle."
        ];
    }

    public function users($request)
    {
        $data = PayrollCutoff::with('cycle')->where('id', $request->id)->first();

        switch ($request->type) {
            case 'All Regular Employees':
                $users = User::whereHas('organization', function ($query) {
                    $query->where('type_id', 15)->where('status_id', 2);
                })->pluck('id');
                break;
            case 'Custom Employees':
                $users = $request->users;
                break;
            case 'Except Employees':
                $users = User::whereNotIn('id', $request->users)->whereHas('organization', function ($query) {
                    $query->where('type_id', 15)->where('status_id', 2);
                })->pluck('id');
                break;
        }

        // NEW: Track existing payrolls and incomplete DTRs
        $existingUserIds = [];
        $incompleteUserIds = [];

        foreach ($users as $user) {
            $exist = Payroll::where('user_id', $user)->where('cutoff_id', $request->id)->first();

            if ($exist) {
                $existingUserIds[] = $user;
                continue; // Skip processing if already exists
            }

            if ($this->hasIncomplete($data, $user) > 0) {
                $incompleteUserIds[] = $user;
                continue; // Skip processing if has incomplete DTR
            }

            // ... proceed with payroll creation
            $payroll = $data->payrolls()->create([
                'user_id' => $user,
                'cutoff_id' => $request->id
            ]);

            if ($payroll) {
                $salary = floatval(str_replace(['₱', ','], '', optional(UserOrganization::with('salary')->where('user_id', $user)->first())->salary?->amount));

                if ($data->type == '1st') {
                    $total = 0;
                    $deductions = UserDeduction::where('is_active', 1)->where('is_automatic', 1)->where('user_id', $user)->get();

                    foreach ($deductions as $deduction) {
                        PayrollDeduction::create([
                            'amount' => $deduction->amount,
                            'deduction_id' => $deduction->deduction_id,
                            'payroll_id' => $payroll->id
                        ]);
                        $cleanAmount = floatval(str_replace(['₱', ','], '', $deduction->amount));
                        $total += $cleanAmount;
                    }

                    $payroll->gross = $salary;
                    $payroll->deduction = $total;
                    $payroll->netpay = $salary - $total;

                    if (!$data->cycle->is_regular) {
                        $tardiness = $this->tardiness($data, $user, $salary);
                        $payroll->mins = $tardiness['mins'];
                        $payroll->days = $tardiness['days'];
                        $payroll->tardiness = $tardiness['total'];
                        $payroll->netpay = ($salary / 2) - ($tardiness['total'] + $total);
                    }

                    $payroll->save();

                } elseif ($data->type == '2nd') {
                    $previous = Payroll::where('user_id', $user)
                        ->whereHas('cutoff', function ($query) use ($data) {
                            $query->where('cycle_id', $data->cycle_id);
                        })
                        ->first();

                    $tardiness = $this->tardiness($data, $user, $salary);
                    $previous_net = (floatval(str_replace(['₱', ','], '', $previous->gross)) / 2) - floatval(str_replace(['₱', ','], '', $previous->tardiness));
                    $tax = ($previous_net + (($salary / 2) - $tardiness['total'])) * 0.02;

                    $payroll->gross = $salary;
                    $payroll->deduction = $tax;
                    $payroll->mins = $tardiness['mins'];
                    $payroll->days = $tardiness['days'];
                    $payroll->tardiness = $tardiness['total'];
                    $payroll->netpay = ($salary / 2) - ($tardiness['total'] + $tax);
                    $payroll->save();

                    $deduction = UserDeduction::where('is_active', 1)->where('is_automatic', 0)->where('user_id', $user)->first();
                    PayrollDeduction::create([
                        'amount' => $tax,
                        'deduction_id' => $deduction->deduction_id,
                        'payroll_id' => $payroll->id
                    ]);

                } else {
                    // Other payroll type
                    $total = 0;
                    $deductions = UserDeduction::where('is_active', 1)->where('is_automatic', 1)->where('user_id', $user)->get();

                    foreach ($deductions as $deduction) {
                        PayrollDeduction::create([
                            'amount' => $deduction->amount,
                            'deduction_id' => $deduction->deduction_id,
                            'payroll_id' => $payroll->id
                        ]);
                        $cleanAmount = floatval(str_replace(['₱', ','], '', $deduction->amount));
                        $total += $cleanAmount;
                    }

                    $payroll->gross = $salary;
                    $payroll->deduction = $total;
                    $payroll->netpay = $salary - $total;

                    if (!$data->cycle->is_regular) {
                        $tardiness = $this->tardiness($data, $user, $salary);
                        $payroll->mins = $tardiness['mins'];
                        $payroll->days = $tardiness['days'];
                        $payroll->tardiness = $tardiness['total'];
                        $payroll->netpay = ($salary / 2) - ($tardiness['total'] + $total);
                    }

                    $payroll->save();
                }
            }
        }

        return [
            'data' =>['exist' => $existingUserIds, 'incomplete' => $incompleteUserIds],
            'existing_users' => $existingUserIds,
            'incomplete_users' => $incompleteUserIds,
            'message' => 'Cycle creation was successful!',
            'info' => "You've successfully created a new cycle."
        ];
    }


    private function hasIncomplete($data,$user){
        $start = Carbon::parse($data->start);
        $end = Carbon::parse($data->end);
        $holidays = ['2025-06-06', '2025-06-12'];
        $incomplete = Dtr::where('user_id',$user)
        ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
        ->whereNotIn('date', $holidays)
        ->where('is_completed',0)
        ->count();

        return $incomplete;
    }  

    private function tardiness($data,$user,$salary){
        $start = Carbon::parse($data->start);
        $end = Carbon::parse($data->end);
        $holidays = ['2025-06-06', '2025-06-12'];
        $period = CarbonPeriod::create($start, $end);
        $filteredPeriod = collect($period)->reject(function ($date) use ($holidays) {
            return in_array($date->toDateString(), $holidays);
        });
        $lateMinutes = 0;
        $undertimeMinutes = 0;
        $absentDays = 0;

        $dtrs = Dtr::where('user_id',$user)
        ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
        ->whereNotIn('date', $holidays)
        ->get()
        ->keyBy(fn ($dtr) => Carbon::parse($dtr->date)->toDateString());
        $test = [];

        foreach ($filteredPeriod as $day) {
            if ($day->isWeekend()) {
                continue;
            }

            $dayString = $day->toDateString();
            $dtr = $dtrs[$dayString] ?? null;
            if($dtr){
                $hasAmLogs = !empty($dtr->am_in_at) && !empty($dtr->am_out_at);
                $hasPmLogs = !empty($dtr->pm_in_at) && !empty($dtr->pm_out_at);
            
                if (!$hasAmLogs) {
                    $test[] = $dtr;
                    $absentDays += 0.5;
                }

                if (!$hasPmLogs) {
                     $test[] = $dtr;
                    $absentDays += 0.5;
                }

                if ($hasAmLogs && $hasPmLogs) {
                    $amin = json_decode($dtr->am_in_at);
                    $amout = json_decode($dtr->am_out_at);
                    $pmin = json_decode($dtr->pm_in_at);
                    $pmout = json_decode($dtr->pm_out_at);

                    $lateMinutes += $amin->minutes + $pmin->minutes;
                    $undertimeMinutes += $amout->minutes + $pmout->minutes;
                }
            }else{
                $absentDays += 1;
            }
        }
     
        $dailyRate = $salary / 22;
        $perMinuteRate = $dailyRate / 480;

        $absenceDeduction = round($dailyRate * $absentDays, 2);
        $lateDeduction = round($perMinuteRate * $lateMinutes, 2);
        $undertimeDeduction = round($perMinuteRate * $undertimeMinutes, 2);
        $totalDeduction = $absenceDeduction + $lateDeduction + $undertimeDeduction;

        return [
            'days' => $absentDays,
            'mins' => $undertimeMinutes + $lateMinutes,
            'total' => $totalDeduction
        ];
    }

    private function generateCode(){
        $year = date('Y'); 
        $c = PayrollCycle::whereYear('created_at',$year)->where('code','!=',NULL)->count();
        $code = 'R9-'.date('m').date('Y').'-'.str_pad(($c+1), 4, '0', STR_PAD_LEFT); 
        return $code;
    }

    private function generateCode2(){
        $year = date('Y'); 
        $c = PayrollCutoff::whereYear('created_at',$year)->where('code','!=',NULL)->count();
        $code = 'R9CFF-'.date('m').date('Y').'-'.str_pad(($c+1), 4, '0', STR_PAD_LEFT); 
        return $code;
    }
}
