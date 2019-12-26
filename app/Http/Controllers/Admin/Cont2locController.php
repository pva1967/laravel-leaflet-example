<?php

namespace App\Http\Controllers;

use App;
use App\Contact;
use App\Institution;
use App\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Cont2locController extends Controller
{
    public function edit(Outlet $outlet)
    {

        $user=Auth::user();

        if (null == $user) {
            App::abort(403, 'Требуется авторизация');
        }
        $this->authorize('view_post', $outlet);
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

        $contactQuery = Contact::query();
        $contactQuery->where('creator_id', $user_id);
        $contacts = $contactQuery->paginate(25);
        $contact_locs = DB::table('cont2locs')->where ('loc_id', $outlet->id)->pluck('cont_id')->toArray();
        return view('cont2loc.edit', compact('outlet', 'contact_locs', 'contacts'));
    }

    public function store(Request $request, Outlet $outlet)
    {
        //dd($request->input('contact'));
        $contacts= $request->input('contact');
        DB::delete('delete from cont2locs where loc_id ='.$outlet->id);
        //dd($deleted);
        if ($contacts) {
            foreach ($contacts as $contact) {
                DB::table('cont2locs')->insert(
                    ['loc_id' => $outlet->id, 'cont_id' => $contact]
                );
            }
        }
        return  redirect()->route('outlets.show', $outlet);
    }
}
