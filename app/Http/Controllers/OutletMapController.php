<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Support\Facades\Auth;

class OutletMapController extends Controller
{
    /**
     * Show the outlet listing in LeafletJS map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $user=Auth::user();
        $admin = Auth::guard('admin')->user();

        $isAdmin = $admin ? 1:0;
        $user_id = $user ? $user->id : null;


        if (null!=$user or null != $admin) {

            return view('outlets.map', compact('user_id', 'isAdmin'));
        }
       else {
           return view('auth.login');
       }
    }
}
