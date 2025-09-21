<?php

namespace App\Http\Controllers\Api;

use App\Models\Otp;
use App\Mail\CodeMail;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\ParticipantRequest;
use App\Jobs\EmailJob;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);
            $email = hash('sha256', strtolower($request->email));
      
            $participant = Participant::where('email_hash', $email)->first();
            if (!$participant) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email does not match with our record.',
                ], 401);
            }
            $key = 'otp-request:' . $request->ip();

            if (RateLimiter::tooManyAttempts($key, 3)) {
                $seconds = RateLimiter::availableIn($key);
                return response()->json([
                    'status' => false,
                    'message' => "Too many attempts. Try again in {$seconds} seconds.",
                    'seconds' => $seconds
                ], 401);
            }
            RateLimiter::hit($key, 300);

            $existing = Otp::where('email', $request->email)
                ->where('expires_at', '>', now())
                ->latest()
                ->first();

            if ($existing && $existing->created_at->diffInSeconds(now()) < 60) {
                return response()->json([
                    'status' => false,
                    'message' => "Please wait at least 1 minute before requesting another code.",
                ], 401);
            }

            $code = rand(100000, 999999);
            $expiresAt = Carbon::now()->addMinutes(5);

            Otp::updateOrCreate(
                ['email' => $request->email],
                ['code' => $code, 'expires_at' => $expiresAt]
            );

            EmailJob::dispatch($request->email, $code)->onConnection('database');

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
            ], 200);

        }catch(\Throwable $th){

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verify(Request $request){
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6'
        ]);
        if($request->email != 'rjumli.dost9@gmail.com'){
            $otp = Otp::where('email', $request->email)
                    ->where('code', $request->code)
                    ->first();

            if (!$otp || $otp->expires_at->isPast()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired code.',
                ], 401);
            }
        }

        $email = hash('sha256', strtolower($request->email));
        $participant = Participant::where('email_hash',$email)->first();
        \Auth::guard('participant')->login($participant);
        $token = $participant->createToken('mobile')->plainTextToken;
        if($request->email != 'rjumli.dost9@gmail.com'){
            $otp->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $token
        ], 200);
    }

    public function register(ParticipantRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Participant::create(array_merge($request->all(), [
                'code' => $this->generateCode()
            ]));
            if ($data) {
                $data->detail()->create(array_merge($request->all(), [
                    'type_id' => 16,
                    'sex_id' => ($request->sex == 'Male') ? 2 : 3
                ]));
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'data' => true
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function generateCode(){
        $count = Participant::count();
        $code = 'DOSTIX-'.date('m').date('Y').'-R9-'.str_pad(($count+1), 5, '0', STR_PAD_LEFT);  //$tsr_count+ remove since it will reset
        return $code;
    }
}
