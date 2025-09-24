<?php

namespace App\Http\Controllers\Api;

use App\Models\Dropdown;
use Illuminate\Support\Facades\DB;
use App\Models\ParticipantPoint;
use App\Models\CsfEntry;
use App\Models\CsfQuestion;
use App\Models\EventSession;
use App\Models\EventSessionParticipant;
use App\Models\EventExhibitor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\Data\FeedbackResource;
use App\Http\Resources\DefaultResource;
use App\Events\SessionEvent;
use App\Events\ExhibitorEvent;
use App\Jobs\CertificateJob;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;

class CsfController extends Controller
{
    public function index(Request $request)
    {   
        $data = CsfQuestion::where('is_active',1)->where('is_rating',1)->get();
        return DefaultResource::collection($data);
    }

    public function session(Request $request){
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
        // $this->participation($request->session_id,$request->participant_id);
        return response()->json([
            'status' => true,
            'message' => 'CSF submitted successfully',
            'data' => new FeedbackResource($entry)
        ], 200);
    }

    private function certificate($session,$participant){
        $data = EventSessionParticipant::with('participant','session.event.detail.municipality')->where('session_id',$session)->where('participant_id',$participant)->first(); 
        $array = [
            'data' => $data
        ]; 

        $pdf = \PDF::loadView('certificates.appearance',$array)->setPaper('a4', 'portrait');
        $pdfContent = base64_encode($pdf->output());
        CertificateJob::dispatch($data->participant->email, $array, $pdfContent)->onConnection('database');
    }

    private function participation($session,$participant){
        $data = EventSessionParticipant::with('participant','session.venue','session.schedules','session.event.detail.municipality')->where('session_id',$session)->where('participant_id',$participant)->first(); 
        $array = [
            'data' => $data
        ]; 

        $pdf = \PDF::loadView('certificates.participation',$array)->setPaper('a4', 'portrait');
        $pdfContent = base64_encode($pdf->output());
        CertificateJob::dispatch($data->participant->email, $array, $pdfContent)->onConnection('database');
    }

    public function exhibitor(Request $request){
        $validated = $request->validate([
            'exhibitor_id' => 'required|exists:event_exhibitors,id',
            'participant_id' => 'required|exists:participants,id',
            'comment' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'required|integer|exists:csf_questions,id',
            'questions.*.rating' => 'required|integer|min:1|max:5',
        ]);

        $exhibitor = EventExhibitor::where('id',$request->exhibitor_id)->first();
        $ratings = collect($request->questions)->pluck('rating'); 
        $entry = $exhibitor->feedbackable()->create([
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
        if($entry) {
            $engage = Dropdown::find(28);
            $point = ParticipantPoint::where('participant_id', $request->participant_id)->firstOrFail();

            $entry->engageable()->create([
                'points'   => $engage->others,
                'type_id'  => $engage->id,
                'point_id' => $point->id,
            ]);

            $point->points += $engage->others;
            $point->save();

            $data = [
                'participant_id'        => $request->participant_id,
                'points'    => $engage->others
            ];
            broadcast(new SessionEvent($data, 'plus'));
        }
        broadcast(new SessionEvent(new FeedbackResource($entry),'ex-rating'));
        return response()->json([
            'status' => true,
            'message' => 'CSF submitted successfully',
            'data' => new FeedbackResource($entry)
        ], 200);
    }

}
