<?php

namespace App\Services\Session;

use Hashids\Hashids;
use App\Models\EventSession;
use App\Http\Resources\SessionResource;
use App\Http\Resources\SessionViewResource;

class ViewClass
{

    public function lists($request){
        $data = SessionResource::collection(
            EventSession::with('venue','detail','schedules','participants.participant.detail','attendees.participant','status','activities.speaker','managers.user.profile')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->when($request->keyword, function ($query,$keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->whereHas('event', function($query){
                $query->where('is_active',1);
            })
            ->whereHas('managers', function($query){
                $query->where('user_id',\Auth::user()->id);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function view($id){
       
        $hashids = new Hashids('krad',10);
        $key = $hashids->decode($id);

        $data = new SessionViewResource(
            EventSession::with('venue','detail','schedules','participants.participant.detail','attendees.participant','status','activities.speaker','managers.user.profile')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->where('id',$key[0])->first()
        );
        return $data;
    }
}
