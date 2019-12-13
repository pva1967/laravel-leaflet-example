<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Cont2instController extends Controller
{
    public function edit()
    {
        $user=Auth::user();
        if ($user->is_Admin()) {
         $session = Session::get('SA_Inst_id');
            if (null !== $session) {
                $inst_id = $session;
            } else {
                $inst_id = Institution::first()->id;
            }
        $user_id = Institution::find(strval($inst_id))->creator_id;
        }
        else {
            $user_id = $user->id;
        }
        $institution = DB::table('institutions')->where('creator_id', $user_id)->first();
        $contactQuery = Contact::query();
        $contactQuery->where('creator_id', $user_id);
        $contacts = $contactQuery->paginate(25);
        $contact_insts = DB::table('cont2insts')->where ('inst_id', $institution->id)->pluck('cont_id')->toArray();
        return view('cont2inst.edit', compact('institution', 'contact_insts', 'contacts'));
    }

    /**
     * @param Request $request
     * @param Institution $institution
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //dd($request->input('contact'));
        $user=Auth::user();
        if ($user->is_Admin()) {
            $session = Session::get('SA_Inst_id');
            if (null !== $session) {
                $inst_id = $session;
            } else {
                $inst_id = Institution::first()->id;
            }
            $user_id = Institution::find(strval($inst_id))->creator_id;
        }
        else {
            $user_id = $user->id;
        }
        $institution = DB::table('institutions')->where('creator_id', $user_id)->first();
        dd($institution);
        $contacts= $request->input('contact');
        DB::delete('delete from cont2insts where inst_id ='.$institution->id);
        //dd($deleted);
        if ($contacts) {
            foreach ($contacts as $contact) {
                DB::table('cont2insts')->insert(
                    ['inst_id' => $institution->id, 'cont_id' => $contact]
                );
            }
        }
        return  redirect()->route('institution.show');
    }
}
