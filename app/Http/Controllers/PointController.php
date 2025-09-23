<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DropdownClass;

class PointController extends Controller
{
    
    public function __construct(DropdownClass $dropdown){
        $this->dropdown = $dropdown;
    }

      public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->view->lists($request);
            break;
            default :
            return inertia('Modules/Points/Index',[
                'types' => $this->dropdown->dropdowns('Participant Type'),
                'affiliations' => $this->dropdown->affiliations()
            ]);
        }
    }
}
