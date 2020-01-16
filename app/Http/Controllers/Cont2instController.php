<?php

namespace App\Http\Controllers;

use App;
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
        $institution = DB::table('institutions')->where('creator_id', $user_id)->first();
        //dd($institution);
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
        if (preg_match('/admin/', $request->getRequestUri())){
            return redirect()->route('admin.institution.show');
        }
        else {
            return redirect()->route('institution.show');
        }
    }
}
