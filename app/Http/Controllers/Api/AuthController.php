<?php

namespace App\Http\Controllers\Api;

use App\Models\Otp;
use App\Mail\CodeMail;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);
            $email = hash('sha256', $request->email);
        
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

            Mail::to($request->email)->send(new CodeMail($code));
            // return response()->json(['success' => true]);
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

        $otp = Otp::where('email', $request->email)
                  ->where('code', $request->code)
                  ->first();

        if (!$otp || $otp->expires_at->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired code.',
            ], 401);
        }

        $email = hash('sha256', $request->email);
        $participant = Participant::where('email_hash',$email)->first();
        \Auth::guard('participant')->login($participant);
        $token = $participant->createToken('mobile')->plainTextToken;
        $otp->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $token
        ], 200);
    }
}
