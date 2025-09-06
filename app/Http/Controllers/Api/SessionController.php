<?php

namespace App\Http\Controllers\Api;

use App\Models\EventSession;
use App\Models\EventSessionParticipant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\SessionResource;
use App\Http\Resources\Api\SessionViewResource;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $participantId = $request->id;

        $data = EventSession::with('venue','detail','schedules','participants','status','activities.speaker','managers.user.profile')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->whereHas('event',function ($query) {
                $query->where('is_active',1);
            })
            ->with(['participants' => function ($query) use ($participantId) {
                $query->where('participant_id', $participantId);
            }])
            ->get()
            ->map(function ($session) use ($participantId) {
                $session->has_registered = $session->participants->isNotEmpty();
            return $session;
        });
        return SessionResource::collection($data);
    }

    public function view($id){
        $data = EventSession::with('venue','detail','schedules','participants','status','activities.speaker','managers.user.profile')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->whereHas('event',function ($query) {
                $query->where('is_active',1);
            })
            ->where('id',$id)
            ->first();
        return new SessionViewResource($data);
    }

}
