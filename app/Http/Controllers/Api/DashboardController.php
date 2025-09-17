<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotel;
use App\Models\CsfQuestion;
use App\Models\EventExhibitor;
use App\Models\EventSession;
use App\Models\ParticipantPoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Api\HotelResource;
use App\Http\Resources\Api\Data\ExhibitorResource;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->user_id;
        return response()->json([
            'sessions'    => $this->sessions(),
            'exhibitors'  => $this->exhibitors($id),
            'csfs' => $this->csfs(),
            'hotels' => $this->hotels()
        ]);
    }

    public function sessions(){
        return [];
    }

    public function csfs(){
        $data = CsfQuestion::where('is_active', 1)->where('is_rating', 1)->get();
        return DefaultResource::collection($data);
    }

    public function exhibitors($id)
    {
        $data = EventExhibitor::with('contact')
        ->whereHas('event', fn($q) => $q->where('is_active', 1))
        ->withExists([
            'visitors as has_visited' => fn($q) => 
                $q->where('participant_id', $id),
            'visitors as has_voted' => fn($q) =>
                $q->where('participant_id', $id)->where('has_voted', 1),
            'feedbackable as has_feedback' => fn($q) =>
                $q->where('participant_id', $id),
        ])
        ->get();
        return ExhibitorResource::collection($data);
    }

    public function hotels(){
        $data = Hotel::with('location','rates')->where('is_active',1)->get();
        return HotelResource::collection($data);
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
