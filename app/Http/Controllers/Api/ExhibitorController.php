<?php

namespace App\Http\Controllers\Api;

use App\Models\EventExhibitor;
use App\Models\EventExhibitorReview;
use App\Models\EventExhibitorVisitor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Api\ExhibitorResource;
use App\Http\Resources\Api\ExhibitorViewResource;
use App\Events\ExhibitorEvent;

class ExhibitorController extends Controller
{
    public function index(Request $request)
    {
        $participantId = $request->participant_id;

        $data = EventExhibitor::with('contact')
            ->whereHas('event', function ($query) {
                $query->where('is_active', 1);
            })
            ->with(['visitors' => function ($query) use ($participantId) {
                $query->where('participant_id', $participantId);
            }])
            ->get()
             ->map(function ($exhibitor) {
                $visitor = $exhibitor->visitors->first();
                $exhibitor->has_visited = $visitor ? true : false;
                $exhibitor->has_voted = $visitor ? (bool) $visitor->has_voted : false;
                unset($exhibitor->visitors); 
                return $exhibitor;
            });

        return DefaultResource::collection($data);
    }

    public function view(Request $request, $id){
        $participantId = $request->participant_id;

        $data = EventExhibitor::with('contact','feedbackable.participant.detail')
            ->withCount('visitors') // ✅ only gets the count, not full list
            ->find($id);

        if ($data) {
            // Check if this participant has visited
            $visitor = $data->visitors()
                ->where('participant_id', $participantId)
                ->first();

            $data->has_visited = (bool) $visitor;
            $data->has_voted   = $visitor ? (bool) $visitor->has_voted : false;
            $data->feedback = $data->feedbackable
                    ->where('participant_id', $participantId)
                    ->first(); 
            $data->feedbacks = $data->feedbackable;
        }

        return new ExhibitorViewResource($data);
    }

    public function review(Request $request){
        $review = EventExhibitorReview::where('participant_id', $request->participant_id)
            ->where('exhibitor_id', $request->exhibitor_id)
            ->first();
        if($review){
            $review->rate = $request->rate;
            $review->comment = $request->comment;
            $review->save();
        }else{
            $data = EventExhibitorReview::create([
                'rate' => $request->rate,
                'comment' => $request->comment,
                'participant_id' => $request->participant_id,
                'exhibitor_id' => $request->exhibitor_id,
            ]);
        }

        $data = EventExhibitorReview::with('participant.detail')->where('id',$data->id)->first();
        broadcast(new ExhibitorEvent(new ReviewResource($data),'review'));
        return response()->json([
            'status' => true,
            'message' => 'Review submitted successfully',
            'data' => new ReviewResource($data)
        ], 200);
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
