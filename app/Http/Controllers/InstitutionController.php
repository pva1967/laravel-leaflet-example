<?php

namespace App\Http\Controllers;

use App\Institution;
use App\Outlet;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
{
    //
    $user_id = Auth::id();
    $institution = Institution::where('creator_id', '=', $user_id)->firstOrFail();


    if ( ! $institution)
    {
        App::abort(500, 'Нет данных об организации');
    }
    else {
        $name_en = DB::table('instnames')->where('id', $institution->inst_name_id)->select('name_en')->first();
        $institution->name_en = $name_en->name_en;
        return view('institution.edit', compact('institution'));
    }
}

    public function show()
    {
        //
        $user_id = Auth::id();
        $institution = Institution::where('creator_id', '=', $user_id)->firstOrFail();

        if ( ! $institution)
        {
            App::abort(500, 'Нет данных об организации');
        }
        else {
            $name_en = DB::table('instnames')->where('id', $institution->inst_name_id)->select('name_en')->first();
            $institution->name_en = $name_en->name_en;
            $contacts=DB::table('contacts')
                ->join('cont2insts','cont2insts.cont_id' , '=' , 'contacts.id')
                ->where('cont2insts.inst_id', '=', $institution->id)
                ->select('contacts.*')->get();
            return view('institution.show', compact('institution', 'contacts'));
        }
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $instData = $request->validate([
            'address_street'   => 'nullable|max:255',
            'address_city'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
            'venue_type' => 'required'
        ]);
        App\Institution::where('creator_id', $user_id)
                        ->update($instData);

        return redirect()->route('institution.show');
    }
}
