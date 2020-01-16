<?php

namespace App\Http\Controllers;

use App;
use \App\Contact;
use \App\Http\Requests\ContactRequest;
use App\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        //$this->authorize('create');

        // the user can do everything
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



        $contactQuery = Contact::query();
        $contactQuery->where('creator_id', $user_id);
        $contacts = $contactQuery->paginate(25);
        //dd($contacts);
        return view('contacts.index', compact('contacts'));

    }
    public function create()
    {
        $user=Auth::user();
        $admin = Auth::guard('admin')->user();
       if (null==$user and null==$admin) App::abort(403);
       return view('contacts.create');

    }
    public function store(ContactRequest $request)
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


        $newContact = $request->validated();

        $newContact['creator_id'] = $user_id;

        Contact::create($newContact);

        if ($request->is('admin/*')) {
            return redirect()->route('admin.contacts.index');
        }
        else return redirect()->route('contacts.index');
    }

    public function update(ContactRequest $request)
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


        $contact = Contact::find($request->input('update_id'));
        if ($user_id === $contact->creator_id )
        //$this->authorize('update-contact',[]);
        {


            $newContact = $request->validated();

            $newContact['creator_id'] = $user_id;

            $contact->update($newContact);
        }
        else {
            App::abort(500, 'Нет данных об организации');
        }

        if ($request->is('admin/*')) {
            return redirect()->route('admin.contacts.index');
        }
        else return redirect()->route('contacts.index');
    }

    public function edit($id)
    {
        $contactQuery = Contact::query();
        $contact = $contactQuery->where('id', $id)->first();

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

        if ($user_id == $contact->creator_id )
        {
            return view('contacts.edit', compact('contact'));
        }
        else
        {
            App::abort(500, 'Нет данных об организации');
        }

    }

    public function destroy(Request $request)
    {
        $user=Auth::user();
        $admin = Auth::guard('admin')->user();

        $contact_id = strval($request->input('contact_id'));
        $contact = Contact::find($contact_id);

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


            if ($contact->creator_id == $user_id ) {
                $contact->delete();
                if ($admin) {
                    return redirect()->route('admin.contacts.index');
                }
                else return redirect()->route('contacts.index');

            }

        return back();
    }

}
