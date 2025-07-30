<?php

namespace App\Services\Session;

use Hashids\Hashids;
use App\Models\EventSession;
use App\Http\Resources\SessionViewResource;

class ViewClass
{
    public function view($id){
       
        $hashids = new Hashids('krad',10);
        $key = $hashids->decode($id);

        $data = new SessionViewResource(
            EventSession::with('venue','detail','schedules','participants','attendees.participant','status','activities.speaker','managers.user.profile')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->where('id',$key[0])->first()
        );
        return $data;
    }
}
