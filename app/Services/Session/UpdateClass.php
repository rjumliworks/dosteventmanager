<?php

namespace App\Services\Session;

use Hashids\Hashids;
use App\Models\Participant;
use App\Models\EventSession;
use App\Models\EventSessionParticipant;
use App\Events\SessionEvent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Resources\AttendanceResource;

class UpdateClass
{
    public function status($request){
        $session_id = $request->id;
        $status_id = $request->status_id;

        $data = EventSession::with('status')->where('id',$session_id)->first();
        $data->status_id = $status_id;
        $data->save();
        $data = EventSession::with('status')->where('id',$session_id)->first();
        broadcast(new SessionEvent($data,'status'));
        return [
            'data' => $data->status,
            'message' => 'Event status successfully updated.', 
            'info' => "success"
        ];
    }

    public function attendance($request){
 
        $hashids = new Hashids('krad',10);
        $session_id = $hashids->decode($request->session);
        $code = $request->participant;

        $participant_id = Participant::where('code',$code)->value('id');
        $data = EventSessionParticipant::where('session_id', $session_id)->where('participant_id', $participant_id)->first();

        if (!$data) {
            broadcast(new SessionEvent('You are not a registered participant.','attendance-error'));
            return [
                'data' => '-',
                'message' => 'Activity successfully created.', 
                'info' => "false"
            ];
        }

        if ($data->attended_at) {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'Attendance already recorded for this participant.'
            // ], 400);
            if(!$request->image){
                broadcast(new SessionEvent('Attendance already recorded for this participant.','attendance-error'));
                return [
                    'data' => '-',
                    'message' => 'Attendance already recorded for this participant.', 
                    'info' => "false"
                ];
            }else{
                broadcast(new SessionEvent('Attendance already recorded for this participant.','attendance-image'));
            }
        }

        if($request->image){
            $path = $this->image($request);
            $data->image = $path;
        }
        if(!$data->attended_at){
            $data->attended_at = now();
            $data->status_id = 8;
        }
        $data->save();

        $latest = EventSessionParticipant::with('participant')->where('session_id', $session_id)
        ->where('participant_id', $participant_id)
        ->first();

        return [
            'data' => new AttendanceResource($latest),
            'message' => 'Activity successfully created.', 
            'info' => "success"
        ];

    }

    public function image($request)
    {
        $image = $request->input('image'); // base64 string

        // Validate format
        if (!preg_match('/^data:image\/(\w+);base64,/', $image, $matches)) {
            return response()->json(['error' => 'Invalid image format.'], 422);
        }

        $type = strtolower($matches[1]); // png, jpg, jpeg, gif
        if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
            return response()->json(['error' => 'Invalid image type.'], 422);
        }

        // Remove header and decode
        $image = substr($image, strpos($image, ',') + 1);
        $image = str_replace(' ', '+', $image);
        $imageData = base64_decode($image);

        if ($imageData === false) {
            return response()->json(['error' => 'Base64 decode failed.'], 422);
        }

        // Save to storage/app/public/images/attendance
        $filename = Str::random(10) . '.' . $type;
        $path = 'images/attendance/' . $filename;
        Storage::disk('public')->put($path, $imageData);

        return $path;
    }
}
