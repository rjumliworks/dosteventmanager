<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\User\ViewClass;
use App\Services\User\SaveClass;
use App\Traits\HandlesTransaction;

class UserController extends Controller
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
            return inertia('Modules/Users/Index');
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

}
