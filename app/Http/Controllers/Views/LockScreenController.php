<?php

namespace App\Http\Controllers\Views;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LockScreenController extends Controller
{
    /**
     * Via auth middleware verify user credentials.
     * 
     */
    public function __construct()
    {
//$this->middleware('auth');
    }

    
    public function newClient()
    {
        return view('lockscreens/new_client_form');
    }
    
}
