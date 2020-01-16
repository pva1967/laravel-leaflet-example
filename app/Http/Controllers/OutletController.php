<?php

namespace App\Http\Controllers;

use App;
use App\Outlet;
use App\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OutletController extends Controller
{
    /**
     * Display a listing of the outlet.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $user=Auth::user();
        $admin = Auth::guard('admin')->user();
        if ($admin)
        {
            $session = session('SA_Inst_id');

            if (null !== $session)
            {
                $institution = Institution::find (strval($session));
            }
            else
            {
                $institution = Institution::get()->sortBy('name_ru')->first();
            }
          $user_id = $institution->creator_id;
        }
        elseif (null!==$user )
        {

            $user_id = Auth::id();
        }

        else
        {
            App::abort(500, 'Нет данных об организации');
        }
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
        $user=Auth::user();
        $admin = Auth::guard('admin')->user();

        if (null !== $user  or null !== $admin) {

            return view('outlets.create');
        }
        else {
            return App::abort(403, 'Требуется авторизация');
        }


    }

    /**
     * Store a newly created outlet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $user=Auth::user();
        $admin = Auth::guard('admin')->user();
        if ($admin)
        {
            $session = session('SA_Inst_id');

            if (null !== $session)
            {
                $user_id = Institution::find (strval($session))->creator_id;
                // dd($institution);
            }
            else {
                $user_id = Institution::get()->sortBy('name_ru')->first()->creator_id;
            }
        }
        elseif (null!==$user )
        {

            $user_id = Auth::id();
        }

        else
        {
            App::abort(500, 'Нет данных об организации');
        }


        $newOutlet = $request->validate([
            'name'      => 'required|max:60',
            'address_street'   => 'nullable|max:255',
            'address_city'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
            'AP_no' => 'integer',
            'location_type' => 'required',
            'info_URL' => 'nullable|url'
        ]);

        $newOutlet['creator_id'] = $user_id;
        $inst = Institution::where('creator_id', $user_id)->firstOrFail();
        $inst_id = $inst['inst_id'];
        $count = strval(Outlet::where('creator_id', $user_id)->count()+1);
        $loc_id = $count>8? "{$inst_id}-{$count}":"{$inst_id}-0{$count}";

        $newOutlet['location_id'] = $loc_id;
        $outlet = Outlet::create($newOutlet);

        if ($admin){
            return redirect()->route('admin.outlets.show', $outlet);
        }
        else {
            return redirect()->route('outlets.show', $outlet);
        }
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
        $admin = Auth::guard('admin')->user();
        if ((null !== $user && $user->can('edit', $outlet)) or (null !== $admin)) {

            $contacts = DB::table('contacts')
                ->join('cont2locs', 'cont2locs.cont_id', '=', 'contacts.id')
                ->where('cont2locs.loc_id', '=', $outlet->id)
                ->select('contacts.*')->get();

            return view('outlets.show', compact('outlet', 'contacts'));
        }
        else {
        return App::abort(403, 'Требуется авторизация');
        }

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
        $admin = Auth::guard('admin')->user();


        if ((null !== $user && $user->can('edit', $outlet)) or (null !== $admin)) {
            return view('outlets.edit', compact('outlet'));
        }

        else {
            return App::abort(403, 'Требуется авторизация');
        }
    }


    /**
     * Update the specified outlet in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Outlet $outlet, Request $request)
    {
        $user=Auth::user();
        $admin = Auth::guard('admin')->user();


        if ((null !== $user && $user->can('edit', $outlet)) or (null !== $admin)) {

            $outletData = $request->validate([
                'name' => 'required|max:60',
                'address_street' => 'nullable|max:255',
                'address_city' => 'nullable|max:255',
                'latitude' => 'nullable|required_with:longitude|max:15',
                'longitude' => 'nullable|required_with:latitude|max:15',
                'AP_no' => 'integer',
                'location_type' => 'required',
                'info_URL' => 'nullable|url'
            ]);
            $outlet->update($outletData);

            if ($admin){
                return redirect()->route('admin.outlets.show', $outlet);
            }
           else {
               return redirect()->route('outlets.show', $outlet);
           }
        }
        else {
            return App::abort(403, 'Требуется авторизация');
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
        $user = Auth::user();
        $admin = Auth::guard('admin')->user();


        if ((null !== $user && $user->can('edit', $outlet)) or (null !== $admin)) {

            $outlet->delete();
            $ins = $admin ? 'admin.':'';
            return redirect()->route("{$ins}outlets.index");
        }
        else {
            return App::abort(403, 'Требуется авторизация');
        }

    }
}
