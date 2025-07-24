<?php

namespace App\Services\Session;

use Hashids\Hashids;
use App\Models\EventSession;
use App\Http\Resources\SessionResource;

class ViewClass
{
    public function view($id){
        $hashids = new Hashids('krad',10);
        $key = $hashids->decode($id);

        $data = new SessionResource(
            EventSession::with('event','venue','detail','schedules')->where('id',$key)->first()
        );
        return $data;
    }
}
