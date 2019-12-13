<?php

namespace App\Http\Controllers;

use App\Outlet;
use App\User;
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
        $user_id = Auth::id();
        $user = User::find($user_id);
        if (null !== $user) {
            $isAdmin = $user->is_Admin() ? 1 : 0;
        }
        else {
            $isAdmin = 0;
        }

        if (Auth::check()) {
            return view('outlets.map', compact('user_id', 'isAdmin'));
        }
       else {
           return view('auth.login');
       }
    }
}
