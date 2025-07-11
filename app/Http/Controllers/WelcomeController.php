<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    public function index(){
        return inertia('Welcome');
    }
}
