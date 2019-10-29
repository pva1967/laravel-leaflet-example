<?php

namespace App\Http\Controllers;

use App\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use SoapBox\Formatter\Formatter;
use Geocoder\Provider\Chain\Chain;
use Geocoder\Provider\GeoPlugin\GeoPlugin;
use Geocoder\Provider\GoogleMaps\GoogleMaps;


class OutletController extends Controller
{
    /**
     * Display a listing of the outlet.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('manage_outlet');

            // the user can do everything
        $user_id=Auth::id();

            $outletQuery = Outlet::query();
            $outletQuery->where('name', 'like', '%' . request('q') . '%')->where('creator_id', $user_id);
            $outlets = $outletQuery->paginate(25);
//        $test = Auth::user()->name ;
//        $contents = Storage::disk('public')->get($test.'.xml');
//        $formatter = Formatter::make($contents, Formatter::XML);
//        $contents = var_export($formatter->toArray());
            return view('outlets.index', compact('outlets'));

    }

    /**
     * Show the form for creating a new outlet.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Outlet);

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
        $this->authorize('create', new Outlet);

        $newOutlet = $request->validate([
            'name'      => 'required|max:60',
            'address'   => 'nullable|max:255',
            'address_street'   => 'nullable|max:255',
            'address_city'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);
        $newOutlet['creator_id'] = auth()->id();

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
        $user = Auth::user();
        if (Gate::forUser($user)->allows('view-post', $outlet))  {
            return view('outlets.show', compact('outlet'));
        }
        else {
            return (redirect('/'));
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
        $user = Auth::user();
        if (Gate::forUser($user)->allows('view-post', $outlet))
        {
            return view('outlets.edit', compact('outlet'));
        }
        else
        {
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
        $this->authorize('update', $outlet);

        $outletData = $request->validate([
            'name'      => 'required|max:60',
            'address'   => 'nullable|max:255',
            'address_street'   => 'nullable|max:255',
            'address_city'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);

        $outlet->update($outletData);

        return redirect()->route('outlets.show', $outlet);
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
        $this->authorize('delete', $outlet);

        $request->validate(['outlet_id' => 'required']);

        if ($request->get('outlet_id') == $outlet->id && $outlet->delete()) {
            return redirect()->route('outlets.index');
        }

        return back();
    }
}
