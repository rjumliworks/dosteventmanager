<?php

namespace App\Http\Controllers;

use App\Models\Dtr;
use App\Models\OldDtr;
use App\Models\OldUser;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserInformation;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\DropdownClass;

class DashboardController extends Controller
{
    public function __construct(
            DropdownClass $dropdown,

        ){
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        // $this->dtr($request);
        if(!\Auth::check()){
            return inertia('Auth/Login');
        }else{
            return inertia('Modules/Executive/Dashboard/Index');
        }
    }

    private function information($id){
        $accounts = [
            ["name" => "Pag-Ibig","number" => null,"deduction" => null, "is_contribution" => true],
            ["name" => "SSS","number" => null, "deduction" => null, "is_contribution" => true],
            ["name" => "GSIS", "number" => null, "deduction" => null, "is_contribution" => true],
            ["name" => "PhilHealth", "number" => null, "deduction" => null, "is_contribution" => true],
            ["name" => "TIN",  "number" => null, "deduction" => null, "is_contribution" => false],
            ["name" => "LandBank", "number" => null, "deduction" => null, "is_contribution" => false]
        ];
        
        $family = [
            "parents" => [
                "father" => [
                    "name" => null,
                    "address" => null,
                ],
                "mother" => [
                    "name" => null,
                    "address" => null,
                ]
            ],
            "spouse" => [
                "name" => null,
                "address" => null,
                "contact_no" => null,
                "occupation" => null,
                "company" => null,
            ],
            "children" => []
        ];

        $contacts = [
            "home_address" => [
                "region" => null,
                "province" => null,
                "municipality" => null,
                "barangay" => null,
                "street" => null,
                "zip_code" => null
            ],
            "permanent_address" => [
                "region" => null,
                "province" => null,
                "municipality" => null,
                "barangay" => null,
                "street" => null,
                "zip_code" => null
            ],
            "emergency_contact" => [
                "name" => null,
                "relationship" => null,
                "contact_no" => null,
                "address" => [
                    "region" => null,
                    "province" => null,
                    "municipality" => null,
                    "barangay" => null,
                    "street" => null
                ]
            ]
        ];

        UserInformation::create([
            'accounts' => json_encode($accounts),
            'backgrounds' => json_encode($family),
            'contacts' => json_encode($contacts),
            'user_id' => $id
        ]);
        
        UserRole::create([
            'role_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => $id
        ]);
    }

    public function status($status){
        switch($status){
            case '3':
                return 15;
            break;
            case '2':
                return 17;
            break;
            case '1':
                return 16;
            break;
        }
    }

    public function search(Request $request){
        $option = $request->option;
        switch($option){
            case 'provinces':
                return $this->dropdown->provinces($request->code);
            break;
            case 'municipalities':
                return $this->dropdown->municipalities($request->code);
            break;
            case 'barangays':
                return $this->dropdown->barangays($request->code);
            break;
            case 'units':
                return $this->dropdown->units($request->code);
            break;
            case 'users':
                return $this->dropdown->users($request->keyword,$request->is_regular);
            break;
        }
    }

    public function dtr($request){
        // $time = Carbon::createFromTimestamp(1750119565)->format('g:i A');
        // $timestamp = 1750119565;
        // $time = date('H:i:s', $timestamp); 
        // return $time;

        $startOfMonth = Carbon::now()->startOfMonth()->toDateString(); // e.g., '2025-05-01'
        $startOfMonth = Carbon::create(null, 5, 1)->startOfDay()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();     // e.g., '2025-06-30'
        $dtrs = OldDtr::with('user')->whereBetween('date', [$startOfMonth,$endOfMonth])->get();
      
        foreach($dtrs as $dtr){
            $user = User::with('profile','organization.division')->where('username',strtolower($dtr->user->username))->first();
            if($user){
                $remarks = [
                    'tardiness' => null,
                    'undertime' => null
                ]; 
                $amin = $dtr->inAM 
                ? [
                    'ip' => $dtr->ip,
                    'pcname' => gethostname(),
                    'browser' => $request->header('User-Agent'),
                    'time' =>  date('H:i:s',$dtr->inAM),
                    'date' => $dtr->date,
                    'minutes' => $this->computeLateMinutes('Time In (am)',date('H:i:s',$dtr->inAM)),
                    'is_updated' => false,
                    'changes' => []
                ] 
                : null;

                $amout = $dtr->outAM 
                ? [
                    'ip' => $dtr->ip,
                    'pcname' => gethostname(),
                    'browser' => $request->header('User-Agent'),
                    'time' => date('H:i:s',$dtr->outAM),
                    'date' => $dtr->date,
                    'minutes' => $this->computeLateMinutes('Time Out (am)',date('H:i:s',$dtr->outAM)),
                    'is_updated' => false,
                    'changes' => []
                ] 
                : null;

                $pmin = $dtr->inPM 
                ? [
                    'ip' => $dtr->ip,
                    'pcname' => gethostname(),
                    'browser' => $request->header('User-Agent'),
                    'time' => date('H:i:s',$dtr->inPM),
                    'date' => $dtr->date,
                    'minutes' => $this->computeLateMinutes('Time In (pm)',date('H:i:s',$dtr->inPM)),
                    'is_updated' => false,
                    'changes' => []
                ] 
                : null;

                $pmout = $dtr->outPM 
                ? [
                    'ip' => $dtr->ip,
                    'pcname' => gethostname(),
                    'browser' => $request->header('User-Agent'),
                    'time' => date('H:i:s',$dtr->outPM),
                    'date' => $dtr->date,
                    'minutes' => $this->computeLateMinutes('Time Out (pm)',date('H:i:s',$dtr->outPM)),
                    'is_updated' => false,
                    'changes' => []
                ] 
                : null;

                $data = new Dtr;
                $data->date = $dtr->date;
                $data->am_in_at = ($dtr->inAM) ? json_encode($amin) : null;
                $data->am_out_at = ($dtr->outAM) ? json_encode($amout) : null;
                $data->pm_in_at = ($dtr->inPM) ? json_encode($pmin) : null;
                $data->pm_out_at =  ($dtr->outPM) ? json_encode($pmout) : null;
                $data->remarks = json_encode($remarks);
                $data->user_id = $user->id;
                $data->save();
                $success[] = $dtr->user->username;
            }else{
                $failed[] = $dtr->user->username;
            }
        }
        return [$success,array_unique($failed)];


        // $employees = Employee::where('is_active',1)->get();
        // foreach($employees as $employee){
        //     $user = User::create([
        //         'username' => $employee->username,
        //         'email' => ($employee->email) ? $employee->email : $employee->username.'@gmail.com',
        //         'password' => bcrypt($employee->username.'!@#$%'),
        //         'created_at' => $employee->created_at,
        //         'updated_at' => $employee->updated_at,
        //     ]);
        //     if($user){
        //         $profile = $user->profile()->create([
        //             'firstname' => $employee->first_name,
        //             'middlename' => $employee->middle_name,
        //             'lastname' => $employee->last_name,
        //             'suffix' => $employee->name_suffix,
        //             'sex' => 'Male',
        //             'birthdate' => now(),
        //             'contact_no' => '09123456789',
        //             'avatar' => ($employee->picture) ? $employee->picture : 'avatar.jpg',
        //             'signature' => ($employee->signature) ? $employee->signature : 'signature.jpg',
        //             'marital_id' => 1,
        //             'religion_id' => 1,
        //             'blood_id' => 1,
        //         ]);

        //         if($profile){
        //             $user->organization()->create([
        //                 'status_id' => 2,
        //                 'type_id' => $this->status($employee->employee_status_id),
        //                 'position_id' => 1,
        //                 'division_id' => 1,
        //                 'unit_id' => 1,
        //                 'station_id' => 1
        //             ]);

        //             $this->information($user->id);
        //         }
        //     }
        // }
    }

   public function computeLateMinutes($type,$time)
    {
        $time = Carbon::createFromTimeString($time); 
        switch($type){
            case 'Time In (am)':
                $officialStart = Carbon::createFromTimeString('08:00:00');
                $flexibleCutoff = Carbon::createFromTimeString('08:30:59');
                $minutes = ($time->greaterThan($flexibleCutoff)) ? (int) $officialStart->diffInMinutes($time) : 0;
            break;
            case 'Time Out (am)':
                $officialMorningOut = Carbon::createFromTimeString('12:00:00');
                $minutes = ($time->lessThan($officialMorningOut)) ? ceil($time->diffInMinutes($officialMorningOut)) : 0;
            break;
            case 'Time In (pm)':
                $officialAfternoonTimeIn = Carbon::createFromTimeString('13:00:59');
                $minutes = ($time->greaterThan($officialAfternoonTimeIn)) ? (int) $officialAfternoonTimeIn->diffInMinutes($time) : 0;
            break;
            case 'Time Out (pm)':
                $officialAfternoonOut = Carbon::createFromTimeString('17:00:00');
                $minutes = ($time->lessThan($officialAfternoonOut)) ? ceil($time->floatDiffInMinutes($officialAfternoonOut)) : 0;
            break;
        }
        return $minutes;
    }
}
