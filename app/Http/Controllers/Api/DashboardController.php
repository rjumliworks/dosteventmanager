<?php

namespace App\Http\Controllers\Api;

use App\Models\EventExhibitor;
use App\Models\EventSession;
use App\Models\ParticipantPoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\ParticipantResource;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $participant = $request->user()->load(['detail.sex', 'detail.type']);

        return response()->json([
            'participant' => $participant,
            'sessions'    => $this->sessions(),
            'exhibitors'  => $this->exhibitors(),
            'hotels' => $this->hotels()
        ]);
    }

    public function sessions(){
        return [];
    }

    public function exhibitors(){
        return [];
    }

    public function hotels(){
        return [];
    }

    // public function index(Request $request){
    
        
    //     $array = [
    //         'exhibits' => EventExhibitor::count(),
    //         'sessions' => [],
    //         'hotels' => [],
    //         'points' => 100
    //         // ParticipantPoint::where('participant_id',$request->participant_id)->value('point')
    //     ];
        
    //     return $array;
    // }

    // private function exhibitors(){
    //     $data = EventExhibitor::with('contact')
    //         ->whereHas('event', function ($query) {
    //             $query->where('is_active', 1);
    //         })
    //         ->with(['visitors' => function ($query) use ($participantId) {
    //             $query->where('participant_id', $participantId);
    //         }])
    //         ->get()
    //          ->map(function ($exhibitor) {
    //             $visitor = $exhibitor->visitors->first();
    //             $exhibitor->has_visited = $visitor ? true : false;
    //             $exhibitor->has_voted = $visitor ? (bool) $visitor->has_voted : false;
    //             unset($exhibitor->visitors); 
    //             return $exhibitor;
    //         });

    //     return DefaultResource::collection($data);
    // }
}
