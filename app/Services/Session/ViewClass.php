<?php

namespace App\Services\Session;

use Hashids\Hashids;
use App\Models\CsfQuestion;
use App\Models\EventSession;
use App\Models\EventExhibitor;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Http\Resources\SessionResource;
use App\Http\Resources\SessionViewResource;

class ViewClass
{

    public function lists($request){
        $data = SessionResource::collection(
            EventSession::with('venue','detail','schedules','attendees.participant','status','activities.speaker','managers.user.profile')
            ->with('participants.participant.detail','feedbackable.participant.detail')
            ->with('event.detail.region:code,name,region','event.detail.province:code,name','event.detail.municipality:code,name','event.detail.barangay:code,name')
            ->when($request->keyword, function ($query,$keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->whereHas('event', function($query){
                $query->where('is_active',1);
            })
            ->whereHas('managers', function($query){
                $query->where('user_id',\Auth::user()->id);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function view($id){
       
        $hashids = new Hashids('krad',10);
        $key = $hashids->decode($id);

        $data = new SessionViewResource(
           EventSession::with([
                'venue','detail','schedules',
                'participants.participant.detail',
                'participants.participant.csfs' => function ($q) use ($key) {
                    $q->where('feedbackable_type', EventSession::class)
                    ->where('feedbackable_id', $key[0]);
                },
                'attendees' => function ($q) {
                    $q->orderBy('attended_at', 'DESC');
                },
                'attendees.participant',
                'status','activities.speaker',
                'managers.user.profile',
                'event.detail.region:code,name,region',
                'event.detail.province:code,name',
                'event.detail.municipality:code,name',
                'event.detail.barangay:code,name',
                'questions.participant.detail'
            ])
            ->where('id',$key[0])->first()
        );
        return $data;
    }

  public function print($request)
{
    $id = $request->id;

    if ($request->typee === 'session') {
        $session = EventSession::findOrFail($id);
        $type = 'App\\Models\\EventSession';
    } else {
        $session = EventExhibitor::findOrFail($id);
        $type = 'App\\Models\\EventExhibitor';
    }

    // ✅ Get all questions (even if they have 0 ratings)
    $questions = CsfQuestion::where('is_rating', 1)
        ->with(['ratings' => function ($q) use ($id, $type) {
            $q->whereHas('csf', function ($csf) use ($id, $type) {
                $csf->where('feedbackable_type', $type)
                    ->where('feedbackable_id', $id);
            });
        }])
        ->get();

    $pdf = \PDF::loadView('prints.csf', [
        'session' => $session->title,
        'questions' => $questions,
    ])->setPaper('a4', 'portrait');

    return $pdf->stream($session->title . '.pdf');
}

}
