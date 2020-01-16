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
            App::abort(403, 'Требуется авторизация');
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

        if (preg_match('/admin/', $request->getRequestUri())){
        return redirect()->route('admin.outlets.show', $outlet);
        }
        else {
        return redirect()->route('outlets.show', $outlet);
        }
    }
}
