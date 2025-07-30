<?php

namespace App\Services\Session;

use Hashids\Hashids;
use App\Models\Participant;
use App\Models\EventSessionParticipant;

class UpdateClass
{
    public function attendance($request){
        $hashids = new Hashids('krad',10);
        $session_id = $hashids->decode($request->session);
        $code = $request->participant;

        $participant_id = Participant::where('code',$code)->value('id');
        $data = EventSessionParticipant::where('session_id',$session_id)->where('participant_id',$participant_id)->first();
        $data->attended_at = now();
        $data->save();

        
        $data = EventSessionParticipant::where('session_id', $session_id)
        ->where('participant_id', $participant_id)
        ->first();


        $data->attended_at = now();
        $data->status_id = 8;
        $data->save();

        $latest = EventSessionParticipant::with('participant')->where('session_id', $session_id)
        ->where('participant_id', $participant_id)
        ->first();

        return [
            'data' => $latest,
            'message' => 'Activity successfully created.', 
            'info' => "success"
        ];

    }
}
