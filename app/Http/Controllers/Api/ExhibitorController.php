<?php

namespace App\Http\Controllers\Api;

use App\Models\EventExhibitor;
use App\Models\EventExhibitorVisitor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class ExhibitorController extends Controller
{
    public function index(Request $request)
    {
        $participantId = $request->id;

        $data = EventExhibitor::with('contact')
            ->whereHas('event', function ($query) {
                $query->where('is_active', 1);
            })
            ->with(['visitors' => function ($query) use ($participantId) {
                $query->where('participant_id', $participantId);
            }])
            ->get()
            ->map(function ($exhibitor) use ($participantId) {
                $exhibitor->has_voted = false;

                if ($exhibitor->visitors->isNotEmpty()) {
                    $visitor = $exhibitor->visitors->first();
                    $exhibitor->has_voted = (bool) $visitor->has_voted;
                }
                unset($exhibitor->visitors); 
                return $exhibitor;
            });

        return DefaultResource::collection($data);
    }

    public function attendance(Request $request)
    {
        $visitor = EventExhibitorVisitor::where('participant_id', $request->participant_id)
            ->where('exhibitor_id', $request->exhibitor_id)
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

    public function vote(Request $request)
    {
        $visitor = EventExhibitorVisitor::where('participant_id', $request->participant_id)
        ->where('exhibitor_id', $request->exhibitor_id)
        ->first();

        if(!$visitor) {
            $visitor = $this->recordAttendance($request->participant_id, $request->exhibitor_id);
        }

        if ($visitor->has_voted) {
            $visitor->update([
                'has_voted' => false,
                'voted_at'  => null,
            ]);
        }else{
            $visitor->update([
                'has_voted' => true,
                'voted_at'  => now(),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Vote submitted successfully!',
            'data' => $visitor->has_voted
        ], 200);
    }

    private function recordAttendance($participantId, $exhibitorId)
    {
        return EventExhibitorVisitor::firstOrCreate(
            [
                'participant_id' => $participantId,
                'exhibitor_id'   => $exhibitorId,
            ]
        );
    }
}
