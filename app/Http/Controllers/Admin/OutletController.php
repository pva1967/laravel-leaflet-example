<?php

namespace App\Http\Controllers;

use App;
use App\Outlet;
use App\User;
use App\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;


class OutletController extends Controller
{
    /**
     * Display a listing of the outlet.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $user = Auth::user();

        if (null == $user)  {
            return App::abort(403, 'Требуется авторизация');
        }
        elseif ($user->is_Admin()) {

            $session = Session::get('SA_Inst_id');
            if (null !== $session) {
                $inst_id = $session;
            } else {
                $inst_id = Institution::first()->id;
            }
            $user = User::find(Institution::find(strval($inst_id))->creator_id);
        }

            $user_id = $user->id;
            $outletQuery = Outlet::query();
            $outletQuery->where('name', 'like', '%' . request('q') . '%')->where('creator_id', $user_id);
            $outlets = $outletQuery->paginate(25);
//
            return view('outlets.index', compact('outlets'));

    }


    /**
     * Show the form for creating a new outlet.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();

        return view('outlets.create');
    }

    /**
     * Store a newly created outlet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (null == $user ) {
            return App::abort(404, 'Требуется авторизация');
        }
        if (!$user->is_Admin())
        {
            $this->authorize('create', new Outlet);
        }
        else
        {
            $session = Session::get('SA_Inst_id');
            if (null !== $session) {
                $inst_id = $session;
            } else {
                $inst_id = Institution::first()->id;
            }
            $user = User::find(Institution::find(strval($inst_id))->creator_id);
        }

        $user_id=$user->id;

        $newOutlet = $request->validate([
            'name'      => 'required|max:60',
            'address_street'   => 'nullable|max:255',
            'address_city'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
            'AP_no' => 'integer',
            'location_type' => 'required',
            'info_URL' => 'nullable|regex:/^(https?\:\/\/)?([a-zA-Z0-9_*]+\.)+[a-zA-Z0-9_*]+(\/[a-zA-Z0-9_*]+)*(\/)?$/'
        ]);

        $newOutlet['creator_id'] = $user_id;
        $inst = Institution::where('creator_id', $user_id)->firstOrFail();
        $inst_id = $inst['inst_id'];
        $count = strval(Outlet::where('creator_id', $user_id)->count()+1);
        $loc_id = $count>8? "{$inst_id}-{$count}":"{$inst_id}-0{$count}";

        $newOutlet['location_id'] = $loc_id;
        $outlet = Outlet::create($newOutlet);
        return redirect()->route('outlets.show', $outlet);
    }

    /**
     * Display the specified outlet.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\View\View
     */
    public function show(Outlet $outlet)
    {
        $user=Auth::user();
        $contacts=DB::table('contacts')
               ->join('cont2locs','cont2locs.cont_id' , '=' , 'contacts.id')
                ->where('cont2locs.loc_id', '=', $outlet->id)
                ->select('contacts.*')->get();

        $this->authorize('view_post', $outlet);
        return view('outlets.show', compact('outlet', 'contacts'));

        /*if ($user->can('view_post', $outlet)) {

             return view('outlets.show', compact('outlet', 'contacts'));
        }

        else {
            return (redirect('/'));
        }*/

    }

    /**
     * Show the form for editing the specified outlet.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\View\View
     */
    public function edit(Outlet $outlet)
    {
        $user=Auth::user();
        if ($user->can('view_post', $outlet)) {
            return view('outlets.edit', compact('outlet'));
        }

        else {
            return (redirect('/'));
        }
    }


    /**
     * Update the specified outlet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, Outlet $outlet)
    {
        $user=Auth::user();
        if ($user->can('view_post', $outlet)) {

            $outletData = $request->validate([
                'name' => 'required|max:60',
                'address_street' => 'nullable|max:255',
                'address_city' => 'nullable|max:255',
                'latitude' => 'nullable|required_with:longitude|max:15',
                'longitude' => 'nullable|required_with:latitude|max:15',
                'AP_no' => 'integer',
                'location_type' => 'required',
                'info_URL' => 'nullable|regex:/^(https?\:\/\/)?([a-zA-Z0-9_*]+\.)+[a-zA-Z0-9_*]+(\/[a-zA-Z0-9_*]+)*(\/)?$/'
            ]);
            $outlet->update($outletData);

            return redirect()->route('outlets.show', $outlet);
        }
        else {
            return (redirect('/'));
        }
    }

    /**
     * Remove the specified outlet from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, Outlet $outlet)
    {
        $user=Auth::user();
        if ($user->can('view_post', $outlet)) {
            $request->validate(['outlet_id' => 'required']);

            if ($request->get('outlet_id') == $outlet->id && $outlet->delete()) {
                return redirect()->route('outlets.index');
            }
        }
        return back();
    }
}
