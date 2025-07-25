<?php

namespace App\Http\Controllers;

use App\Models\Dtr;
use App\Models\OldDtr;
use App\Models\OldUser;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserInformation;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\DropdownClass;

class DashboardController extends Controller
{
    public function __construct(
            DropdownClass $dropdown,
        ){
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        if(!\Auth::check()){
            return inertia('Auth/Login');
        }else{
            return inertia('Modules/Dashboard/Index');
        }
    }

    public function search(Request $request){
        $option = $request->option;
        switch($option){
            case 'provinces':
                return $this->dropdown->provinces($request->code);
            break;
            case 'municipalities':
                return $this->dropdown->municipalities($request->code);
            break;
            case 'barangays':
                return $this->dropdown->barangays($request->code);
            break;
            case 'users':
                return $this->dropdown->users($request->keyword);
            break;
             case 'speakers':
                return $this->dropdown->speakers($request->keyword);
            break;
        }
    }
}
