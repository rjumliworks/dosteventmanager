<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotParticipant
{
    public function handle(Request $request, Closure $next): Response
    {
        
        dd('wew');
        if (!auth('participant')->check()) {
            return redirect()->route('participant.login');
        }

        return $next($request);
    }
}
