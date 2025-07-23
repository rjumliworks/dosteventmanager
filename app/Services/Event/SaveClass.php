<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Http\Resources\EventResource;

class SaveClass
{
    public function event($request){
        $data = Event::create(array_merge($request->all(),[
            'code' => $this->generateCode(),
            'user_id' => \Auth::user()->id
        ]));
        $data = Event::where('id',$data->id)->first();

        return [
            'data' => new EventResource($data),
            'message' => 'Event successfully created.', 
            'info' => "Great job! Your event is now active and ready for participants."
        ];
    }

    private function generateCode(){
        $count = Event::count();
        $code = 'EVENT-'.date('m').date('Y').'-DOSTIX-'.str_pad(($count+1), 4, '0', STR_PAD_LEFT);  //$tsr_count+ remove since it will reset
        return $code;
    }
}
