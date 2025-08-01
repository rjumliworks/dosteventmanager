<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\Exhibitor\ViewClass;
use App\Services\Exhibitor\SaveClass;

class ExhibitorController extends Controller
{
    use HandlesTransaction;

    public function __construct(ViewClass $view, SaveClass $save){
        $this->save = $save;
        $this->view = $view;
    }

    public function show($id){
        return inertia('Modules/Exhibitor/View',[
            'exhibitor' => $this->view->view($id),
        ]);
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'exhibitor':
                    return $this->save->exhibitor($request);
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
                case 'exhibitor':
                    return $this->save->update($request);
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
