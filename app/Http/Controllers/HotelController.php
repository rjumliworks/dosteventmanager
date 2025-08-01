<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Services\Hotel\ViewClass;
use App\Services\Hotel\SaveClass;

class HotelController extends Controller
{
    use HandlesTransaction;

    public function __construct(DropdownClass $dropdown, ViewClass $view, SaveClass $save){
        $this->save = $save;
        $this->view = $view;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->view->lists($request);
            break;
            default :
            return inertia('Modules/Hotels/Index',[
                'dropdowns' => [
                    'regions' => $this->dropdown->regions()
                ]
            ]);
        }
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'hotel':
                    return $this->save->hotel($request);
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
                case 'hotel':
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
