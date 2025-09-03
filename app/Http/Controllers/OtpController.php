<?php

namespace App\Http\Controllers;

use App\Mail\CodeMail;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\Participant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class OtpController extends Controller
{
    public function mail(Request $request){
        $request->validate(['email' => 'required|email']);
        $email = hash('sha256', $request->email);
     
        $participant = Participant::where('email_hash', $email)->first();
        if (!$participant) {
            return response()->json(['success' => false]);
        }
        $key = 'otp-request:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many attempts. Try again in {$seconds} seconds."
            ]);
        }
        RateLimiter::hit($key, 300);

        $existing = Otp::where('email', $request->email)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if ($existing && $existing->created_at->diffInSeconds(now()) < 60) {
            return back()->withErrors([
                'email' => 'Please wait at least 1 minute before requesting another code.'
            ]);
        }

        $code = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(5);

        Otp::updateOrCreate(
            ['email' => $request->email],
            ['code' => $code, 'expires_at' => $expiresAt]
        );

        Mail::to($request->email)->send(new CodeMail($code));
        return response()->json(['success' => true]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6'
        ]);

        $otp = Otp::where('email', $request->email)
                  ->where('code', $request->code)
                  ->first();

        if (!$otp || $otp->expires_at->isPast()) {
            return back()->withErrors(['code' => 'Invalid or expired code.']);
        }

       
        $email = hash('sha256', $request->email);
        $participant = Participant::where('email_hash',$email)->first();
        \Auth::guard('participant')->login($participant);
        // $token = $participant->createToken('mobile')->plainTextToken;
        // Delete OTP after successful login
        $otp->delete();

        return redirect()->route('participant.dashboard')->with([
            'data' => $participant
        ]);
    }
}
