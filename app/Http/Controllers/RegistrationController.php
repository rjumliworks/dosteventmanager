<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\Dropdown;
use App\Models\EventSession;
use App\Models\EventSessionParticipant;
use App\Models\Participant;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Http\Requests\ParticipantRequest;

class RegistrationController extends Controller
{
    use HandlesTransaction;
      
    public function __construct(DropdownClass $dropdown){
        $this->dropdown = $dropdown;
    }

    public function show($type,$key){
        switch($type){
            case 'session':
                return inertia('Registration/Session',[
                    'session' => $this->get($type,$key),
                    'dropdowns' => [
                        'sexs' => $this->dropdown->dropdowns('Sex'),
                        'types' => $this->dropdown->dropdowns('Participant Type')
                    ]
                ]);
            break;
            case 'event':
                return inertia('Registration/Event',[
                    'event' => $this->get($type,$key),
                ]);
            break;
        }
    }

    private function get($type,$key){
        $original = base64_decode($key);
        $hashids = new Hashids('krad',10);
        $key = $hashids->decode($original);

        if($type == 'session'){
            $id = $key[0];
            $data = EventSession::with('detail','venue','event')->where('id',$key)->first();
        }else{
            return $key;
        }

        return $data;
    }

    public function store(ParticipantRequest $request){
    $result = $this->handleTransaction(function () use ($request) {
        $participant = Participant::create(array_merge($request->all(), [
            'code' => $this->generateCode()
        ]));

        if ($participant) {
            $participant->detail()->create($request->all());

            if (count($request->sessions) > 0) {
                foreach ($request->sessions as $session) {
                    EventSessionParticipant::create([
                        'status_id' => 7,
                        'participant_id' => $participant->id,
                        'session_id' => $session,
                    ]);
                }
            }
            // dd(\Auth::guard('participant')->login($participant));
           \Auth::guard('participant')->login($participant);
        }

        return [
            'data' => $participant,
            'message' => 'User information updated successfully.',
            'info' => "All relevant fields have been refreshed with the latest data."
        ];
    });

    return redirect()->route('participant.dashboard')->with([
        'data' => $result['data'],
        'message' => $result['message'],
        'info' => $result['info'],
        'status' => $result['status'],
    ]);
}
    private function generateCode(){
        $count = Participant::count();
        $code = 'DOSTIX-'.date('m').date('Y').'-R9-'.str_pad(($count+1), 5, '0', STR_PAD_LEFT);  //$tsr_count+ remove since it will reset
        return $code;
    }
}
