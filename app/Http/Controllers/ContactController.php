<?php

namespace App\Http\Controllers;

use App;
use \App\Contact;
use \App\Http\Requests\ContactRequest;
use App\Institution;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function index()
    {
        //$this->authorize('create');

        // the user can do everything
        $user = Auth::user();

        if (null == $user ) {
            return App::abort(404, 'Требуется авторизация');
        }
        if ($user->is_Admin())
        {
            $session = Session::get('SA_Inst_id');
            if (null !== $session) {
                $inst_id = $session;
            } else {
                $inst_id = Institution::first()->id;
            }
            $user = User::find(Institution::find(strval($inst_id))->creator_id);
        }
        $user_id = $user->id;

        $contactQuery = Contact::query();
        $contactQuery->where('creator_id', $user_id);
        $contacts = $contactQuery->paginate(25);
        //dd($contacts);
        return view('contacts.index', compact('contacts'));

    }
    public function create()
    {
        $user = Auth::user();
       return view('contacts.create');

    }
    public function store(ContactRequest $request)
    {
        $user = Auth::user();
        if (null == $user ) {
            return App::abort(404, 'Требуется авторизация');
        }
        if ($user->is_Admin())
        {
            $session = Session::get('SA_Inst_id');
            if (null !== $session) {
                $inst_id = $session;
            } else {
                $inst_id = Institution::first()->id;
            }
            $user = User::find(Institution::find(strval($inst_id))->creator_id);
        }
        $user_id = $user->id;

       $newContact = $request->validated();

        $newContact['creator_id'] = $user_id;

        Contact::create($newContact);

        return redirect()->route('contacts.index');
    }
    public function update(ContactRequest $request)
    {
        $user = Auth::user();
        if (null == $user ) {
            return App::abort(404, 'Требуется авторизация');
        }


        $contact = Contact::find($request->input('update_id'));
        if ($user->id === $contact->creator_id or $user->is_Admin())
        //$this->authorize('update-contact',[]);
        {

            if ($user->is_Admin()) {
                $session = Session::get('SA_Inst_id');
                if (null !== $session) {
                    $inst_id = $session;
                } else {
                    $inst_id = Institution::first()->id;
                }
                $user = User::find(Institution::find(strval($inst_id))->creator_id);
            }
            $newContact = $request->validated();

            $newContact['creator_id'] = $user->id;

            $contact->update($newContact);
        }
        return redirect()->route('contacts.index');
    }

    public function edit($id)
    {
        $contactQuery = Contact::query();
        $contact = $contactQuery->where('id', $id)->first();
        $user = Auth::user();
        if (null == $user) return App::abort(404, 'Требуется авторизация');
        if ($user->id == $contact->creator_id or $user->is_Admin())
        {
            return view('contacts.edit', compact('contact'));
        }
        else
        {
            return (redirect('/'));
        }

    }

    public function destroy(Request $request, Contact $contact)
    {
        $user=Auth::user();
        if ($user->can('delete', $contact)) {
            $request->validate(['contact_id' => 'required']);

            if ($request->get('contact_id') == $contact->id && $contact->delete()) {
                return redirect()->route('contacts.index');
            }
        }
        return back();
    }

}
