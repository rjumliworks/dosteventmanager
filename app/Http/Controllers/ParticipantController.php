<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Participant\ViewClass;
use App\Services\Participant\SaveClass;
use App\Traits\HandlesTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ParticipantController extends Controller
{
    use HandlesTransaction;

    public function __construct(ViewClass $view, SaveClass $save){
        $this->save = $save;
        $this->view = $view;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->view->lists($request);
            break;
            default :
            return inertia('Modules/Participants/Index');
        }
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->store($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->update($request);
        });
        
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function view(){
        return inertia('Participant/Index');
    }

    public function login(){
        return inertia('Participant/Login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('participant')->logout(); // logout the participant guard
        $request->session()->invalidate();     // invalidate session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect('/participant/login'); // or any route you prefer
    }
}
