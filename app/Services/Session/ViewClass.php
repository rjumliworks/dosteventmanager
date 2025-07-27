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
            EventSession::with('venue','detail','schedules','participants','status','activities.speaker','managers.user.profile')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->where('id',$key)->first()
        );
        return $data;
    }
}
