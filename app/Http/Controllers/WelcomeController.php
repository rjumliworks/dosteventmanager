<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Services\DropdownClass;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    public function __construct(DropdownClass $dropdown){
        $this->dropdown = $dropdown;
    }


    public function index(){
        return inertia('Welcome',[
            'dropdowns' => [
                'sexs' => $this->dropdown->dropdowns('Sex'),
                'types' => $this->dropdown->dropdowns('Participant Type')
            ],
            'hotels' => Hotel::with('location','rates')->get()
        ]);
    }

    
    public function hotel_index(){
        return inertia('Hotels',[
            'hotels' => Hotel::with('location','rates')->get()
        ]);
    }

    public function highlight_index(){
        return inertia('Highlights',[
            'hotels' => Hotel::with('location','rates')->get()
        ]);
    }

    public function registration_index(){
        return inertia('Registration-Information',[
            'dropdowns' => [
                'sexs' => $this->dropdown->dropdowns('Sex'),
                'types' => $this->dropdown->dropdowns('Participant Type')
            ],
        ]);
    }

}
