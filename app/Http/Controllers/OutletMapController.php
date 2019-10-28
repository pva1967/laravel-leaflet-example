<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutletMapController extends Controller
{
    /**
     * Show the outlet listing in LeafletJS map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user_id=Auth::id();
            return view('outlets.map', compact('user_id'));
        }
       else {
           return view('auth.login');
       }
    }
}
