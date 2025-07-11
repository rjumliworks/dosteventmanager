<?php

namespace App\Services\Hr\Payroll;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Hashids\Hashids;
use App\Models\Dtr;
use App\Models\User;
use App\Models\PayrollCutoff;
use App\Http\Resources\Hr\PayrollResource;
use App\Http\Resources\Hr\CutoffResource;

class ViewClass
{
    public function lists($request){
        $data = CutoffResource::collection(
            PayrollCutoff::with('cycle','status')
            ->with('user:id,username','user.profile:id,user_id,firstname,middlename,lastname,suffix')
            ->with('payrolls.deductions.deduction')
            ->with('payrolls.user.profile:id,user_id,firstname,middlename,lastname,suffix')
            ->with('payrolls.user:id,username','payrolls.user.organization:id,user_id,position_id,salary_id,type_id','payrolls.user.organization.position:id,name','payrolls.user.organization.type:id,name','payrolls.user.organization.salary:id,grade,amount')
            ->withSum('payrolls as total', 'netpay')
            ->withCount('payrolls as count')
            ->orderBy('created_at', 'DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function payroll($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->id);
        
        $data = PayrollResource::collection(
            User::select('id','username')
            ->with([
                'profile:id,user_id,firstname,middlename,lastname,suffix',
                'organization:id,user_id,position_id,salary_id',
                'organization.position:id,name',
                'organization.salary:id,grade,amount',
                'deductions' => function ($query) {
                    $query->where('is_active', 1);
                }
            ])
            ->withSum(['deductions as total_deductions' => function ($query) {
                $query->where('is_active', 1);
            }], 'amount')
            ->whereHas('organization', function ($query) {
                $query->where('status_id', 2);
            })
            ->whereHas('deductions', function ($query) {
                $query->where('is_active', 1);
            })
            ->get()
        );
        return $data;
    }

    public function view($code){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($code);

        $data = new CutoffResource(
            PayrollCutoff::query()
            ->with('cycle','status')
            ->with('user:id,username','user.profile:id,user_id,firstname,middlename,lastname,suffix')
            ->with('payrolls.deductions.deduction')
            ->with('payrolls.user.profile:id,user_id,firstname,middlename,lastname,suffix')
            ->with('payrolls.user:id,username','payrolls.user.organization:id,user_id,position_id,salary_id,type_id','payrolls.user.organization.type:id,name','payrolls.user.organization.position:id,name','payrolls.user.organization.salary:id,grade,amount')
            ->withSum('payrolls as total', 'netpay')
            ->withCount('payrolls as count')
            ->where('id',$id)->first()
        );
        return $data;
    }

    public function print($request){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($request->code);
        $data = PayrollCutoff::with('cycle')
        ->with('payrolls.deductions.deduction')
        ->with('payrolls.user.profile:id,user_id,firstname,middlename,lastname,suffix')
        ->with('payrolls.user:id,username','payrolls.user.organization:id,user_id,position_id,salary_id','payrolls.user.organization.position:id,name','payrolls.user.organization.salary:id,grade,amount')
        ->where('id',$id)
        ->first();

        if($data->cycle->is_regular){
            return $this->regular($data);
        }else{
            return $this->nonregular($data);
        }
    }

    private function regular($data){
        $deductionNames = [
            'Philhealth n/a',
            'Pag-ibig I n/a',
            'Pag-ibig II n/a',
            'HDMF Housing Loan n/a',
            'Multi-Purpose Loan Pag-ibig Loan',
            'Calamity Loan Pag-ibig Loan',
            'Current Month GSIS Life',
            'Prior Year GSIS Life',
            'Policy Loan n/a',
            'Multi-Purpose Loan n/a',
            'SIKAT MDABP n/a',
            'SSS Contribution n/a',
            'AMAPHIL n/a',
            'Withholding Tax n/a',
        ];

        $totalSalary = 0;
        $totalDeductions = array_fill_keys($deductionNames, 0);
        $totalNetAmount = 0;
        $totalDeductionAmount = 0;
        $totalFirstAmount = 0;

        $payrolls = $data->payrolls->sortBy(function ($payroll) {
            return optional($payroll->user->profile)->lastname . ' ' .optional($payroll->user->profile)->firstname. ' ' .optional($payroll->user->profile)->middlename[0];
        })
        ->values()
        ->map(function ($payroll) use (&$totalSalary, &$totalDeductions, &$totalNetAmount,&$totalDeductionAmount,&$totalFirstAmount, $deductionNames) {
            $salary = optional($payroll->user->organization->salary)->amount ?? 0;
            $totalSalary += floatval(str_replace(['₱', ','], '', $salary));
            $deductions = array_fill_keys($deductionNames, 0);

            foreach ($payroll->deductions as $d) {
                $name = optional($d->deduction)->name.' '.optional($d->deduction)->subtype;
                if (isset($deductions[$name])) {
                    $deductions[$name] += floatval(str_replace(['₱', ','], '', $d->amount));
                    $totalDeductions[$name] += floatval(str_replace(['₱', ','], '', $d->amount));
                }
            }

            $net = (float) str_replace(['₱', ','], '', $payroll->netpay);
            $firstHalf = round($net / 2, 2);
            $totalNetAmount += floatval(str_replace(['₱', ','], '', $net));
            $totalDeductionAmount += floatval(str_replace(['₱', ','], '', $payroll->deduction));
            $totalFirstAmount += floatval(str_replace(['₱', ','], '', $firstHalf));
            
            return [
                'id' => $payroll->id,
                'deduction' => $payroll->deduction,
                'netpay' => $payroll->netpay,
                'username' => $payroll->user->username ?? '',
                'name' => optional($payroll->user->profile)->lastname . ' ' .optional($payroll->user->profile)->firstname. ' ' .optional($payroll->user->profile)->middlename[0],
                'position' => optional($payroll->user->organization->position)->name,
                'salary' => optional($payroll->user->organization->salary)->amount,
                'grade' => optional($payroll->user->organization->salary)->grade,
                'deductions' => $deductions,
                'first' => $firstHalf
            ];
        });

        $start = Carbon::parse($data->start);
        $end = Carbon::parse($data->end);

        $cutoff = [
            'title' => 'PAYROLL FOR THE PERIOD OF ' . strtoupper($start->format('F')) . ' ' . $start->format('d') . '-' . $end->format('d') . ', ' . $end->format('Y'),
            'payrolls' => $payrolls,
            'totals' => [
                'salary' => $totalSalary,
                'deductions' => $totalDeductions,
                'net' => $totalNetAmount,
                'deduction' => $totalDeductionAmount,
                'first' => $totalFirstAmount
            ]
        ];

        return inertia('Modules/HumanResource/Payrolls/Components/Pages/View',[
            'cutoff' => $cutoff,
            'deductionHeaders' => $deductionNames,
        ]);
    }

    private function nonregular($data){
        if($data->type == '1st'){
            $deductionNames = [
                'SSS Contribution',
                'ECC-SSS',
                'Pag-Ibig Contribution',
                'Pag-Ibig II',
                'Philhealth'
            ];
        }else{
            $deductionNames = [
                'Withholding Tax',
            ];
        }

        $totalSalary = 0;
        $totalDeductions = array_fill_keys($deductionNames, 0);
        $totalDeductionAmount = 0;
        $totalFirstAmount = 0;
        $totalNetAmount = 0;
        $totalSecondAmount = 0;

        $payrolls = $data->payrolls->sortBy(function ($payroll) {
            return optional($payroll->user->profile)->lastname . ' ' .optional($payroll->user->profile)->firstname. ' ' .optional($payroll->user->profile)->middlename[0];
        })
        ->values()
        ->map(function ($payroll) use (&$totalSalary, &$totalDeductions, &$totalDeductionAmount,&$totalFirstAmount,&$totalNetAmount,&$totalSecondAmount, $deductionNames,$data) {
            $salary = optional($payroll->user->organization->salary)->amount ?? 0;
            $totalSalary += floatval(str_replace(['₱', ','], '', $salary));
            $deductions = array_fill_keys($deductionNames, 0);

            foreach ($payroll->deductions as $d) {
                $name = $d->deduction->name;
                if (isset($deductions[$name])) {
                    $deductions[$name] += floatval(str_replace(['₱', ','], '', $d->amount));
                    $totalDeductions[$name] += floatval(str_replace(['₱', ','], '', $d->amount));
                }
            }

            $sal = (float) str_replace(['₱', ','], '', $payroll->user->organization->salary->amount);
            $firstHalf = round($sal / 2, 2);
            $secondHalf = round($sal - $firstHalf, 2);

            $totalDeductionAmount += floatval(str_replace(['₱', ','], '', $payroll->deduction));
            $totalFirstAmount += floatval(str_replace(['₱', ','], '', $firstHalf));
            $totalSecondAmount += floatval(str_replace(['₱', ','], '', $secondHalf));

            // $tardiness = $this->tardiness($data,$payroll);

            $dailyRate = $sal / 22;
            $perMinuteRate = $dailyRate / 480;

            $absenceDeduction = round($dailyRate * $payroll->days, 2);
            $lateDeduction = round($perMinuteRate * $payroll->mins, 2);
           
            return [
                'id' => $payroll->id,
                'username' => $payroll->user->username ?? '',
                'name' => optional($payroll->user->profile)->lastname . ' ' .optional($payroll->user->profile)->firstname. ' ' .optional($payroll->user->profile)->middlename[0],
                'position' => optional($payroll->user->organization->position)->name,
                'salary' => optional($payroll->user->organization->salary)->amount,
                'grade' => optional($payroll->user->organization->salary)->grade,
                'deduction' => $payroll->deduction,
                'netpay' => $payroll->netpay,
                'mins' => $payroll->mins,
                'days' => $payroll->days,
                'deductions' => $deductions,
                'first' => $firstHalf,
                'second' => $secondHalf,
                'tardiness' => $payroll->tardiness,
                'absence' =>  $absenceDeduction,
                'late' => $lateDeduction
            ];
        });

        $start = Carbon::parse($data->start);
        $end = Carbon::parse($data->end);

        $cutoff = [
            'title' => 'PAYROLL FOR THE PERIOD OF ' . $this->getQuincenaDates($data->cycle->year,$data->cycle->month,$data->type),
            'payrolls' => $payrolls,
            'type' => $data->type,
            'date' => $this->getQuincenaDates($data->cycle->year,$data->cycle->month,$data->type),
            'totals' => [
                'salary' => $totalSalary,
                'deductions' => $totalDeductions,
                'deduction' => $totalDeductionAmount,
                'first' => $totalFirstAmount
            ]
        ];


        return inertia('Modules/HumanResource/Payrolls/Components/Pages/Nonregular',[
            'cutoff' => $cutoff,
            'deductionHeaders' => $deductionNames,
        ]);
    }

    private function getQuincenaDates($year, $month, $half) {
        // Ensure $month is a number (e.g., 6 for June)
        if (!is_numeric($month)) {
            $month = Carbon::parse("1 $month")->month;
        }

        if ($half === '1st') {
            $start = Carbon::create($year, $month, 1)->startOfDay();
            $end = Carbon::create($year, $month, 15)->endOfDay();
        } else {
            $start = Carbon::create($year, $month, 16)->startOfDay();
            $end = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();
        }

        // Format output: July 1–15
        $label = $start->format('F') . ' ' . $start->day . '–' . $end->day .', '.$start->format('Y');

        return $label;
    }

    private function tardiness($data,$payroll){
        $start = $data->start;
        $end = $data->end;
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        $period = CarbonPeriod::create($start, $end);
        
        $lateMinutes = 0;
        $undertimeMinutes = 0;
        $absentDays = 0;

        $scheduledIn = Carbon::parse('08:00');
        $flexEnd = Carbon::parse('08:30');
        $expectedMinutes = 480;

        $dtrs = Dtr::where('user_id', $payroll->user_id)
        ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
        ->get()
        ->keyBy(fn ($dtr) => Carbon::parse($dtr->date)->toDateString());
        
        foreach ($period as $day) {
            if ($day->isWeekend()) {
                continue;
            }

            $dayString = $day->toDateString();
            $dtr = $dtrs[$dayString] ?? null;

            $hasAmLogs = !empty($dtr->am_in_at) && !empty($dtr->am_out_at);
            $hasPmLogs = !empty($dtr->pm_in_at) && !empty($dtr->pm_out_at);
            
            if (!$hasAmLogs && !$hasPmLogs) {
                $absentDays += 1;
            }elseif(!$hasAmLogs || !$hasPmLogs) {
                $absentDays += 0.5;
            }else{
                $amin = json_decode($dtr->am_in_at);
                $amout = json_decode($dtr->am_out_at);
                $pmin = json_decode($dtr->pm_in_at);
                $pmout = json_decode($dtr->pm_out_at);

                $lateMinutes += $amin->minutes + $pmin->minutes;
                $undertimeMinutes += $amout->minutes + $pmout->minutes;
            }
        }

        $salary = (float) str_replace(['₱', ','], '', $payroll->user->organization->salary->amount);
        $dailyRate = $salary / 22;
        $perMinuteRate = $dailyRate / 480;

        $absenceDeduction = round($dailyRate * $absentDays, 2);
        $lateDeduction = round($perMinuteRate * $lateMinutes, 2);
        $undertimeDeduction = round($perMinuteRate * $undertimeMinutes, 2);

        return  [
            'days' => $absentDays,
            'mins' => $undertimeMinutes + $lateMinutes,
            'absence_deduction' => $absenceDeduction,
            'late_deduction' => $lateDeduction + $undertimeDeduction
        ];
    }
}
