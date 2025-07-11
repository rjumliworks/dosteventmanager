<?php

namespace App\Http\Controllers\Auth;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Profile\ViewClass;
use App\Services\Profile\SaveClass;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    use HandlesTransaction;

    public function __construct(ViewClass $view, SaveClass $save){
        $this->view = $view;
        $this->save = $save;
    }

    public function index(Request $request){
        $options = $request->option;
        switch($options){
            case 'authentication-logs':
                return $this->view->authenticationlogs($request);
            break;
            case 'activity-logs':
                return $this->view->activitylogs($request);
            break;
            case 'statistics':
                return $this->view->statistics();
            break;
            case 'sessions':
                return $this->view->sessions($request);
            break;
            default: 
            return inertia('Auth/Profile/Index');
        }
    }

    public function store(Request $request)
    {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->save($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(ProfileRequest $request){
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

    public function destroy(Request $request)
    {
        return $this->save->destroy($request);
    }

}
