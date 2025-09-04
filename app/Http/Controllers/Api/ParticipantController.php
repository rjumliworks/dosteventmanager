<?php

namespace App\Http\Controllers\Api;

use App\Models\Participant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function participant(){
        $email = hash('sha256', $request->email);
        $participant = Participant::where('email_hash',$email)->first();
    }
}
