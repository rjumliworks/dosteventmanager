<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        //
    }

    // 👇 Add this method
    protected function unauthenticated(Request $request, AuthenticationException $exception): Response
    {
        $guard = $exception->guards()[0] ?? null;

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        switch ($guard) {
            case 'participant':
                return redirect()->guest(route('participant.login'));
            default:
                return redirect()->guest(route('login'));
        }
    }
}
