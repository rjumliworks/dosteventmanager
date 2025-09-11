<?php

namespace App\Http\Controllers\Api;

use App\Models\CsfEntry;
use App\Models\CsfQuestion;
use App\Models\EventSession;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\FeedbackResource;
use App\Http\Resources\DefaultResource;
use App\Events\SessionEvent;
use App\Jobs\CertificateJob;
use Illuminate\Support\Facades\Mail;

class CsfController extends Controller
{
    public function index(Request $request)
    {   
        $data = CsfQuestion::where('is_active',1)->where('is_rating',1)->get();
        return DefaultResource::collection($data);
    }

    public function save(Request $request){
        $validated = $request->validate([
            'session_id' => 'required|exists:event_sessions,id',
            'participant_id' => 'required|exists:participants,id',
            'comment' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'required|integer|exists:csf_questions,id',
            'questions.*.rating' => 'required|integer|min:1|max:5',
        ]);

        $session = EventSession::where('id',$request->session_id)->first();
        $ratings = collect($request->questions)->pluck('rating'); 
        $entry = $session->feedbackable()->create([
            'rate' => round($ratings->avg(),1),
            'comment' => $request->comment,
            'participant_id' => $request->participant_id
        ]);
        foreach($request->questions as $question){
            $entry->ratings()->create([
                'rating' => $question['rating'],
                'question_id' => $question['id']
            ]);
        }
        $entry->refresh();
        broadcast(new SessionEvent(new FeedbackResource($entry),'rating'));
        $this->certificate($request->session_id,$request->participant_id);
        return response()->json([
            'status' => true,
            'message' => 'Question submitted successfully',
            'data' => new FeedbackResource($entry)
        ], 200);
    }

    private function certificate($session,$participant){
        $data = EventSessionParticipant::with('participant','session.event.detail.municipality')->where('session_id',$session)->where('participant_id',$participant)->first();

        $url = $_SERVER['HTTP_HOST'].'/verification/'.$participant;
        $qrCode = new QrCode($url);
        $qrCode->setSize(300);
        $pngWriter = new PngWriter();
        $qrCodeImageString = $pngWriter->write($qrCode)->getString();
        $base64Image = 'data:image/png;base64,' . base64_encode($qrCodeImageString);
        
        $array = [
            'qrCodeImage' => $base64Image,
            'data' => $data
        ]; 

        $pdf = \PDF::loadView('certificates.appearance',$array)->setPaper('a4', 'portrait');
        CertificateJob::dispatch($data->participant->email, $array)->onConnection('database');
    }

}
