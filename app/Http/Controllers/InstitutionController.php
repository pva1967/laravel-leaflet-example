<?php

namespace App\Http\Controllers;

use App\Institution;
use App\Realm;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

    $user = Auth::user();
    if (null!==$user && $user->is_Admin())
    {
        $session = session('SA_Inst_id');

        if (null !== $session){
            $institution = Institution::find (strval($session));
            // dd($institution);
        }
        else {
            $institution = Institution::first();
        }
    }
    else{
        $user_id = Auth::id();
        $institution = Institution::where('creator_id', '=', $user_id)->firstOrFail();
    }


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
        $user=Auth::user();
       if (null!==$user && $user->is_Admin())
       {
           $session = session('SA_Inst_id');

           if (null !== $session){
               $institution = Institution::find (strval($session));
              // dd($institution);
           }
           else {
               $institution = Institution::first();
           }
       }
       else{
           $user_id = Auth::id();
           $institution = Institution::where('creator_id', '=', $user_id)->firstOrFail();
       }

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
            $realms = Realm::where('inst_id', $institution->id)->get();
            return view('institution.show', compact('institution', 'contacts', 'realms'));
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (null!==$user && $user->is_Admin())
        {
            $session = session('SA_Inst_id');

            if (null !== $session){
                $institution = Institution::find (strval($session));
                // dd($institution);
            }
            else {
                $institution = Institution::first();
            }
        }
        else{
            $user_id = Auth::id();
            $institution = Institution::where('creator_id', '=', $user_id)->firstOrFail();
        }

        $inst_data = Validator::make($request->all(), [
            'address_street'   => 'nullable|max:255',
            'address_city'   => 'nullable|max:255',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
            'venue_type' => 'required',
            'info_URL_en' => 'regex:/^(https?\:\/\/)?([a-zA-Z0-9_*]+\.)+[a-zA-Z0-9_*]+(\/[a-zA-Z0-9_*]+)*(\/)?$/',
            'info_URL_ru'=> 'nullable|regex:/^(https?\:\/\/)?([a-zA-Z0-9_*]+\.)+[a-zA-Z0-9_*]+(\/[a-zA-Z0-9_*]+)*(\/)?$/',
            'policy_URL_en'=> 'regex:/^(https?\:\/\/)?([a-zA-Z0-9_*]+\.)+[a-zA-Z0-9_*]+(\/[a-zA-Z0-9_*]+)*(\/)?$/',
           'policy_URL_ru'=> 'nullable|regex:/^(https?\:\/\/)?([a-zA-Z0-9_*]+\.)+[a-zA-Z0-9_*]+(\/[a-zA-Z0-9_*]+)*(\/)?$/',
        ]) -> validate();

        $institution->update($inst_data);
        return redirect()->route('institution.show');
    }
}
