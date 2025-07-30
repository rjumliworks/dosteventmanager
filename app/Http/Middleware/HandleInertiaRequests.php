<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Http\Resources\UserResource;
use App\Http\Resources\ParticipantViewResource;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {   
        return [
            ...parent::share($request),
            'user' => (\Auth::guard('web')->check())
                ? new UserResource(User::with('profile')->find(\Auth::guard('web')->id()))
                : null,
            'participant' => (\Auth::guard('participant')->check())
                ? new ParticipantViewResource(\App\Models\Participant::with('detail.sex','detail.type')->find(\Auth::guard('participant')->id()))
                : null,
            'flash' => [
                'data' => session('data'),
                'message' => session('message'),
                'info' => session('info'),
                'status' => session('status'),
                'type' => session('type')
            ]
        ];
    }
}