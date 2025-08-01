<?php

namespace App\Services\Hotel;

use App\Models\Hotel;
use App\Models\HotelRates;

class SaveClass
{
    public function hotel($request){
        $data = Hotel::create(array_merge($request->all(),[
            'code' => $this->generateCode()
        ]));
        if($data){
            $data->location()->create($request->except(['name','link','email','contact_no','is_active','option']));
            foreach($request->rates as $r){
                $rate = new HotelRates;
                $rate->name = $r['name'];
                $rate->detail = $r['detail'];
                $rate->rate = $r['rate'];
                $rate->hotel_id = $data->id;
                $rate->save();
            }
        }
        return [
            'data' => $data,
            'message' => 'Hotel successfully created.', 
            'info' => "Great job! Your event is now active and ready for participants."
        ];
    }

    private function generateCode(){
        $count = Hotel::count();
        $code = 'HOT-'.date('m').date('Y').'-'.str_pad(($count+1), 4, '0', STR_PAD_LEFT);  //$tsr_count+ remove since it will reset
        return $code;
    }
}
