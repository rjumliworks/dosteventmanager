<?php

namespace App\Services\Hotel;

use App\Models\Hotel;

class SaveClass
{
    public function hotel($request){
        $event = Hotel::create(array_merge($request->all(),[
            'code' => $this->generateCode()
        ]));
        if($event){
            $event->location()->create($request->except(['name','link','email','contact_no','is_active','option']));
        }
        return [
            'data' => $event,
            'message' => 'Event successfully created.', 
            'info' => "Great job! Your event is now active and ready for participants."
        ];
    }

    private function generateCode(){
        $count = Hotel::count();
        $code = 'HOT-'.date('m').date('Y').'-'.str_pad(($count+1), 4, '0', STR_PAD_LEFT);  //$tsr_count+ remove since it will reset
        return $code;
    }
}
