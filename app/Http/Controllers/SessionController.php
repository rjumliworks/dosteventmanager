<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Services\Session\ViewClass;
use App\Services\Session\SaveClass;
use App\Services\Session\UpdateClass;

class SessionController extends Controller
{
    use HandlesTransaction;

    public function __construct(DropdownClass $dropdown, ViewClass $view, SaveClass $save, UpdateClass $update){
        $this->save = $save;
        $this->view = $view;
        $this->update = $update;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->view->lists($request);
            break;
            default :
            return inertia('Modules/Session/Index',[
                'dropdowns' => [
                    'regions' => $this->dropdown->regions()
                ]
            ]);
        }
    }

    public function show($id){
        return inertia('Modules/Session/View',[
            'session' => $this->view->view($id),
        ]);
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'session':
                    return $this->save->session($request);
                break;
                case 'activity':
                    return $this->save->activity($request);
                break;
                case 'manager':
                    return $this->save->manager($request);
                break;
            }
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
            switch($request->option){
                case 'session':
                    return $this->update->session($request);
                break;
                case 'activity':
                    return $this->update->activity($request);
                break;
                case 'manager':
                    return $this->update->manager($request);
                break;
            }
        });
        
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }
}
