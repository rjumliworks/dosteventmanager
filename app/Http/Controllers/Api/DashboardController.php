<?php

namespace App\Http\Controllers\Api;

use App\Models\EventExhibitor;
use App\Models\EventSession;
use App\Models\ParticipantPoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        $array = [
            'exhibits' => EventExhibitor::count(),
            'sessions' => EventSession::count(),
            'points' => 100
            // ParticipantPoint::where('participant_id',$request->participant_id)->value('point')
        ];
        
        return $array;
    }
}
