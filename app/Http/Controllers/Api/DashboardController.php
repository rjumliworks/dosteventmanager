<?php

namespace App\Http\Controllers\Api;

use App\Models\Hotel;
use App\Models\CsfQuestion;
use App\Models\EventSession;
use App\Models\EventExhibitor;
use App\Models\ParticipantPoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Api\Data\HotelResource;
use App\Http\Resources\Api\Data\SessionResource;
use App\Http\Resources\Api\Data\ExhibitorResource;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->user_id;
        return response()->json([
            'sessions'    => $this->sessions($id),
            'exhibitors'  => $this->exhibitors($id),
            'csfs' => $this->csfs(),
            'hotels' => $this->hotels()
        ]);
    }

    public function sessions($id)
    {
        $data = EventSession::with('venue','detail','schedules','status','activities.speaker','managers.user.profile')
        ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
        ->whereHas('event',function ($query) {
            $query->where('is_active',1);
        })
        ->withExists([
            'participants as has_registered' => fn($q) => 
                $q->where('participant_id', $id),
            'feedbackable as has_feedback' => fn($q) =>
                $q->where('participant_id', $id),
        ])
        ->get();
        return SessionResource::collection($data);
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
}
