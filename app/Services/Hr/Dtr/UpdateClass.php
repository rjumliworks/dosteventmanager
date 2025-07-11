<?php

namespace App\Services\Hr\Dtr;

use Carbon\Carbon;
use App\Models\Dtr;
use App\Http\Resources\Hr\DtrResource;

class UpdateClass
{   
    public function add($request){
        $dtr = Dtr::where('id',$request->id)->first();
        $info = [
            'ip' => \Request::ip(), 
            'pcname' => gethostname(),
            'browser' => $request->header('User-Agent'),
            'time' =>  $request->time,
            'minutes' => 0,
            'date' => $dtr->date,
            'is_updated' => true,
            'changes' => [
                \Auth::user()->profile->firstname.' '.\Auth::user()->profile->lastname." added the time that is blank to your DTR: {$request->time} with the following note : {$request->remarks}."
            ]
        ];

        if($dtr){
            switch($request->type){
                case 'Time In (am)':
                    $status = 'Success';
                    $dtr->am_in_at = json_encode($info);
                    $dtr->save();
                break;
                case 'Time Out (am)':
                    $status = 'Success';
                    $dtr->am_out_at = json_encode($info);
                    $dtr->save();
                break;
                case 'Time In (pm)':
                    $status = 'Success';
                    $dtr->pm_in_at = json_encode($info);
                    $dtr->save();
                break;
                case 'Time Out (pm)':
                    $status = 'Success';
                    $dtr->pm_out_at = json_encode($info);
                    $dtr->save();
                break;
            }
        }

        $data =  new DtrResource(Dtr::with('user:id,email,username','user.profile:user_id,firstname,middlename,lastname')->where('id',$request->id)->first());
        return [
            'data' => $data,
            'message' => 'DTR Updated successfully.', 
            'info' => 'Your dtr was updated already.',
        ];
    }

    public function save($request){
        $data = Dtr::where('id',$request->id)->first();
        switch($request->type){
            case 'Time In (AM)':
                $column = 'am_in_at';
            break;
            case 'Time Out (AM)':
                $column = 'am_out_at';
            break;
            case 'Time In (PM)':
                $column = 'pm_in_at';
            break;
            case 'Time Out (PM)':
                $column = 'pm_out_at';
            break;
        }
        $timeData = json_decode($data->$column, true);
        $timeData['time'] = $request->to_time;
        $timeData['changes'][] = 
        \Auth::user()->profile->firstname.' '.\Auth::user()->profile->lastname." updated the time from {$request->from_time} to ".Carbon::parse($request->to_time)->format('h:i A')." with the following note : {$request->remarks}.";
        $timeData['is_updated'] = true;
        // $remarks = json_decode($data->remarks, true);
        // if (!is_array($remarks)) {
        //     $remarks = ['tardiness' => null, 'undertime' => null, 'changes' => []];
        // }

        // if (!isset($remarks['changes']) || !is_array($remarks['changes'])) {
        //     $remarks['changes'] = [];
        // }
        
        
        
        $data->update([$column => json_encode($timeData),'is_updated' => 1]);
        $data =  new DtrResource(Dtr::with('user:id,email,username','user.profile:user_id,firstname,middlename,lastname')
        ->where('id',$request->id)->first());

        return [
            'data' => $data,
            'message' => 'DTR Updated successfully.', 
            'info' => 'Your dtr was updated already.',
        ];
    }
}
