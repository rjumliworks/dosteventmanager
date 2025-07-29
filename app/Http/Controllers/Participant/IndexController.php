<?php

namespace App\Http\Controllers\Participant;

use Hashids\Hashids;
use App\Models\EventSession;
use App\Http\Resources\SessionResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function qrcode(){
        return inertia('Participant/Qrcode');
    }

    public function sessions(){
        return inertia('Participant/Sessions');
    }

    public function schedules(){
        return inertia('Participant/Schedules',[
            'sessions' =>  SessionResource::collection(
                EventSession::with('venue','detail','schedules','participants','status','activities.speaker','managers.user.profile')
                ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
                ->whereHas('event',function ($query) {
                    $query->where('is_active',1);
                })
                ->get()
            )
        ]);
    }

    public function scheduleview($id){
        $hashids = new Hashids('krad',10);
        $key = $hashids->decode($id);

        $data = new SessionResource(
            EventSession::with('venue','detail','schedules','participants','status','activities.speaker','managers.user.profile')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->where('id',$key[0])->first()
        );
        return inertia('Participant/Schedulesview',[
            'session' => $data
        ]);
    }

    public function settings(){
        return inertia('Participant/Settings');
    }
}
