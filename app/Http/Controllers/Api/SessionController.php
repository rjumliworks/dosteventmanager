<?php

namespace App\Http\Controllers\Api;

use App\Models\EventSession;
use App\Models\EventSessionParticipant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Api\SessionResource;

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

    public function attendance(Request $request)
    {
        $visitor = EventSessionParticipant::where('participant_id', $request->participant_id)
            ->where('session_id', $request->session_id)
            ->first();

        if ($visitor) {
            return response()->json([
                'status' => false,
                'message' => 'Attendance already recorded for this participant.'
            ], 400);
        }

        $visitor = $this->recordAttendance($request->participant_id, $request->exhibitor_id);

        return response()->json([
            'status' => true,
            'message' => 'Attendance successfully recorded.',
            'data' => $visitor
        ], 201);
    }
}
