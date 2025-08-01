<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Services\Event\ViewClass;
use App\Services\Event\SaveClass;
use App\Services\Event\VenueClass;


class EventController extends Controller
{
    use HandlesTransaction;

    public function __construct(DropdownClass $dropdown, ViewClass $view, SaveClass $save, VenueClass $venue){
        $this->save = $save;
        $this->view = $view;
        $this->venue = $venue;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->view->lists($request);
            break;
            default :
            return inertia('Modules/Event/Index',[
                'dropdowns' => [
                    'regions' => $this->dropdown->regions()
                ]
            ]);
        }
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'event':
                    return $this->save->event($request);
                break;
                case 'venue':
                    return $this->venue->save($request);
                break;
                case 'exhibitor':
                    return $this->save->exhibitor($request);
                break;
                case 'speaker':
                    return $this->save->speaker($request);
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
                case 'event':
                    return $this->save->event($request);
                break;
                case 'venue':
                    return $this->venue->update($request);
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

    public function show($id){
        return inertia('Modules/Event/View',[
            'event' => $this->view->view($id),
        ]);
    }

}
