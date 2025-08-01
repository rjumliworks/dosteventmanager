<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\Speakers;
use App\Http\Resources\EventResource;

class SaveClass
{
    public function event($request){
        $event = Event::create(array_merge($request->all(),[
            'code' => $this->generateCode(),
            'user_id' => \Auth::user()->id
        ]));
        if($event){
            $event->detail()->create($request->except(['name','year','start','end','is_active','option']));
        }
        return [
            'data' => $event,
            'message' => 'Event successfully created.', 
            'info' => "Great job! Your event is now active and ready for participants."
        ];
    }

    private function generateCode(){
        $count = Event::count();
        $code = 'EVENT-'.date('m').date('Y').'-DOSTIX-'.str_pad(($count+1), 4, '0', STR_PAD_LEFT);  //$tsr_count+ remove since it will reset
        return $code;
    }

    public function speaker($request){
        $speaker = Speakers::create($request->all());
        $data = [
            'value' => $speaker->id,
            'name' => $speaker->name,
            'title' => $speaker->title,
            'establishment' => $speaker->establishment,
        ];
        return [
            'data' => $data,
            'message' => 'Speaker successfully created.', 
            'info' => "Great job! You can now select the speaker in the activity"
        ];
    }
}
