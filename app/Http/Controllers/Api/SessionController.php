<?php

namespace App\Http\Controllers\Api;

use App\Models\EventSession;
use App\Models\EventSessionQuestion;
use App\Models\EventSessionParticipant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Api\SessionResource;
use App\Http\Resources\Api\SessionViewResource;
use App\Http\Resources\Api\QuestionResource;
use App\Events\QuestionEvent;

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

    public function view(Request $request, $id){
        $participantId = $request->participant_id;
        $data = EventSession::with('venue','detail','schedules','participants','questions','status','activities.speaker','managers.user.profile','feedbackable.participant.detail')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->where('id',$id)
            ->first();
            
            if($data){
                $data->has_registered = $data->participants()
                    ->where('participant_id', $participantId)
                    ->exists();
            }
        return new SessionViewResource($data);
    }

    public function question(Request $request){
        $data = EventSessionQuestion::create([
            'question' => $request->question,
            'participant_id' => $request->participant_id,
            'session_id' => $request->session_id,
        ]);

        $data = EventSessionQuestion::with('participant.detail')->where('id',$data->id)->first();
        broadcast(new QuestionningEvent(new QuestionResource($data)));
        return response()->json([
            'status' => true,
            'message' => 'Question submitted successfully',
            'data' => new QuestionResource($data)
        ], 200);
    }

    public function registration(Request $request){
        $data = EventSessionParticipant::create([
            'status_id' => 7,
            'participant_id' => $request->participant_id,
            'session_id' => $request->session_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Registration submitted successfully',
            'data' => true
        ], 200);
    }

    public function cancel(Request $request){
        $data = EventSessionParticipant::where('participant_id',$request->participant_id)->where('session_id',$request->session_id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Registration cancelled successfully',
            'data' => true
        ], 200);
    }
}
