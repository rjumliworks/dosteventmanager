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
use App\Http\Resources\ParticipantListResource;
use App\Events\SessionEvent;

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
        $data = EventSession::with('venue','detail','schedules','participants','questions','status','activities.speaker','managers.user.profile')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->with(['feedbackable.participant.detail' => function ($q) use ($participantId) {
                $q->where('participant_id', $participantId)
                ->select('id', 'participant_id', 'feedbackable_id', 'feedbackable_type'); 
            }])
            ->where('id',$id)
            ->first();
            
            if($data){
                $data->has_registered = $data->participants()
                    ->where('participant_id', $participantId)
                    ->exists();
            }
        return new SessionViewResource($data);
    }

    public function attendance(Request $request)
    {
        $session_id = EventSession::where('code', $request->session)->value('id');

        if (!$session_id) {
            return response()->json([
                'status' => false,
                'message' => 'Session not found.'
            ], 404);
        }

        $attendance = EventSessionParticipant::where('participant_id', $request->participant_id)
            ->where('session_id', $session_id)
            ->first();

        if (!$attendance) {
            return response()->json([
                'status' => false,
                'message' => 'You are not a registered participant.'
            ], 400);
        }

        if ($attendance->attended_at) {
            return response()->json([
                'status' => false,
                'message' => 'Attendance already recorded for this participant.'
            ], 400);
        }

        $attendance->attended_at = now();
        $attendance->status_id = 8;

        if ($attendance->save()) {
            $latest = EventSessionParticipant::with('participant')->where('session_id', $session_id)
            ->where('id', $attendance->id)
            ->first();
            broadcast(new SessionEvent($latest,'attendance'));
            return response()->json([
                'status' => true,
                'message' => 'Attendance successfully recorded.',
                'data' => $attendance
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to record attendance. Please try again.'
        ], 500);
    }

    public function question(Request $request){
        $data = EventSessionQuestion::create([
            'question' => $request->question,
            'participant_id' => $request->participant_id,
            'session_id' => $request->session_id,
        ]);

        $data = EventSessionQuestion::with('participant.detail')->where('id',$data->id)->first();
        broadcast(new SessionEvent(new QuestionResource($data),'question'));
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
        $data = EventSessionParticipant::with('participant.detail')->where('id',$data->id)->first();
        broadcast(new SessionEvent(new ParticipantListResource($data),'register'));
        return response()->json([
            'status' => true,
            'message' => 'Registration submitted successfully',
            'data' => true
        ], 200);
    }

    public function cancel(Request $request){
        $data = EventSessionParticipant::with('participant.detail')->where('participant_id',$request->participant_id)->where('session_id',$request->session_id)->first();
        $old = $data;
        $data->delete();
        
        broadcast(new SessionEvent(new ParticipantListResource($old),'cancel'));
        return response()->json([
            'status' => true,
            'message' => 'Registration cancelled successfully',
            'data' => true
        ], 200);
    }

    public function csf(Request $request){
        $data = EventSessionParticipant::with('participant.detail')->where('participant_id',$request->participant_id)->where('session_id',$request->session_id)->first();
        $old = $data;
        $data->delete();
        
        broadcast(new SessionEvent(new ParticipantListResource($old),'cancel'));
        return response()->json([
            'status' => true,
            'message' => 'Registration cancelled successfully',
            'data' => true
        ], 200);
    }
}
