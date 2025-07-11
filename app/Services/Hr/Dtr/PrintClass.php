<?php

namespace App\Services\Hr\Dtr;

use App\Models\Dtr;
use App\Models\UserProfile;
use App\Http\Resources\Hr\PrintDtrResource;

class PrintClass
{
    public function dtr($request){
        $year = $request->year;
        $month = $request->month;
        $user_id = $request->id;

        $user = UserProfile::select('id','user_id','firstname','lastname','middlename')->where('user_id',$user_id)->first();

        $month_number = date("n", strtotime($month));
        $today = date('Y-m-d', strtotime(now()));
        $start_time = strtotime("01-".$month_number."-".$year);
        $end_time = strtotime("+1 month", $start_time);

        for($i=$start_time; $i<$end_time; $i+=86400){
            $date = date('Y-m-d', $i);
            $day = date('l', $i);

            if($day == 'Saturday' || $day == 'Sunday'){
                $array[] = [
                    'date' => date('Y-m-d', $i),
                    'text' => date('F d, Y', $i),
                    'day' => date('l', $i),
                    'data' => 'NON-WORKING DAY',
                    'bg' => 'bg bg-secondary bg-soft',
                    'is_with' => false
                ];
            }else{
                $data = Dtr::whereDate('date',$date)->where('user_id',$user_id)->first();
          
                if($data){
                    if($data->am_in_at == '[]' || $data->am_out_at == '[]' || $data->pm_out_at == '[]' || $data->pm_in_at == '[]'){
                        $is_completed = false;
                    }else{
                        $is_completed = true;
                    }
                    $chck = ($date < $today) ? 'bg bg-soft bg-warning' : '';
                    
                    $array[] = [
                        'date' => date('Y-m-d', $i),
                        'text' => date('F d, Y', $i),
                        'day' => date('l', $i),
                        'data' => [
                            'am_in' => ($data['am_in_at']) ? \Carbon\Carbon::parse(json_decode($data['am_in_at'])->time)->format('h:i') : null,
                            'am_out' => ($data['am_out_at']) ? \Carbon\Carbon::parse(json_decode($data['am_out_at'])->time)->format('h:i') : null,
                            'pm_in' => ($data['pm_in_at']) ? \Carbon\Carbon::parse(json_decode($data['pm_in_at'])->time)->format('h:i') : null,
                            'pm_out' => ($data['pm_out_at']) ? \Carbon\Carbon::parse(json_decode($data['pm_out_at'])->time)->format('h:i') : null,
                        ],
                        'bg' => ($is_completed) ? 'bg bg-soft bg-success' : $chck ,
                        'is_with' => true
                    ];
                }else{
                    if($date < $today){
                        $array[] =  [
                            'date' => date('Y-m-d', $i),
                            'text' => date('F d, Y', $i),
                            'day' => date('l', $i),
                            'data' => 'ABSENT',
                            'bg' => 'bg bg-danger bg-soft',
                            'is_with' => false
                        ];
                    }else{
                        $array[] =  [
                            'date' => date('Y-m-d', $i),
                            'text' => date('F d, Y', $i),
                            'day' => date('l', $i),
                            'data' => [],
                            'bg' => '',
                            'is_with' => true
                        ];
                    }
                }
            }
        }
   
        $array = [
            'lists' => $array,
            'user' => $user,
            'month' => $month,
            'year' => $year
        ];

        $pdf = \PDF::loadView('prints.dtr',$array)->setPaper('a4', 'portrait');
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
      
        return $pdf->stream($month.'-'.$year.'.pdf');
    }

}
