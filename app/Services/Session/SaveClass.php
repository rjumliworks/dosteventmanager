<?php

namespace App\Services\Session;

use App\Models\EventSession;
use App\Models\EventSessionSchedule;

class SaveClass
{
    public function session($request){
        $session = EventSession::create(array_merge($request->all(),[
            'code' => $this->generateCode()
        ]));
        if($session){
            $session->detail()->create($request->all());
            $request->except(['title','is_closed','is_whole_day','is_invitational','is_exclusive','has_registration','venue_id','event_id','option']);
            foreach($request->dates as $date){
                if($date['timeOfDay'] == 'AM'){
                    $start = '08:00:00';
                    $end = '12:00:00';
                }else if($date['timeOfDay'] == 'PM'){
                    $start = '13:00:00';
                    $end = '17:00:00';
                }else if($date['timeOfDay'] == 'Whole Day'){
                    $start = '08:00:00';
                    $end = '17:00:00';
                }else{
                    $start = $date['start_time'];
                    $end = $date['start_time'];
                }
                $schedule = new EventSessionSchedule;
                $schedule->date = $date['date'];
                $schedule->time_of_day = $date['timeOfDay'];
                $schedule->start_time = $start;
                $schedule->end_time = $end;
                $schedule->session_id = $session->id;
                $schedule->save();
            }
        }
        return [
            'data' => $session,
            'message' => 'Event successfully created.', 
            'info' => "Great job! Your event is now active and ready for participants."
        ];
    }

    private function generateCode(){
        $count = EventSession::count();
        $code = 'SES-'.date('m').date('Y').'-DOSTIX-'.str_pad(($count+1), 4, '0', STR_PAD_LEFT);  //$tsr_count+ remove since it will reset
        return $code;
    }
}
