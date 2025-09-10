<?php

namespace App\Http\Controllers\Api;

use App\Models\CsfEntry;
use App\Models\CsfQuestion;
use App\Models\EventSession;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;

class CsfController extends Controller
{
    public function index(Request $request)
    {   
        $data = CsfQuestion::where('is_active',1)->where('is_rating',1)->get();
        return DefaultResource::collection($data);
    }

    public function save(Request $request){
        $session = EventSession::where('id',$request->session_id)->first();
        $session->feedbackable()->create([
            'comment' => $request->comment,
            'participant_id' => $request->participant_id
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Question submitted successfully',
            'data' => true
        ], 200);
    }

}
