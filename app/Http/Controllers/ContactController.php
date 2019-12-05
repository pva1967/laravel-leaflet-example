<?php

namespace App\Http\Controllers;

use \App\Contact;
use \App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function index()
    {
        //$this->authorize('create');

        // the user can do everything
        $user_id=Auth::id();

        $contactQuery = Contact::query();
        $contactQuery->where('creator_id', $user_id);
        $contacts = $contactQuery->paginate(25);
        //dd($contacts);
        return view('contacts.index', compact('contacts'));

    }
    public function create()
    {

       return view('contacts.create');

    }
    public function store(ContactRequest $request)
    {
        $this->authorize('create');

       $newContact = $request->validated();

        $newContact['creator_id'] = Auth::id();

        Contact::create($newContact);

        return redirect()->route('contacts.index');
    }
    public function update(ContactRequest $request)
    {
        $contact = Contact::find($request->input('update_id'));
        $user = Auth::user();
        if ($user->id === $contact->creator_id)
        //$this->authorize('update-contact',[]);
        {
            $newContact = $request->validated();

            $newContact['creator_id'] = Auth::id();
            foreach ($newContact as $key => $value) {
                if ($contact[$key] != $value) $contact[$key] = $value;
            }

            $contact->save();
        }
        return redirect()->route('contacts.index');
    }
    public function edit($id)
    {
        $contactQuery = Contact::query();
        $contact = $contactQuery->where('id', $id)->first();
        $user_id = Auth::id();
        if ($user_id == $contact->creator_id)
        {
            return view('contacts.edit', compact('contact'));
        }
        else
        {
            return (redirect('/'));
        }

    }

}
