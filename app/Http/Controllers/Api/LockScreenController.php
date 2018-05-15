<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LockScreenController extends Controller
{
    /**
     * Via auth middleware verify user credentials.
     * 
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    
    public function lockScreen()
    {
        \Auth::logout();
        return response('logged out', 200);
    }

    public function unlockScreen(Request $request)
    {
        if(Auth::attempt(
            ['email' => $request->input('email'), 
             'password' => $request->input('password')
            ]
        )){
            return response('logged in', 200);
        }else{
            return response('Invalid user', 403);
        }

    }
    
}
