<?php

namespace App\Policies;

use App\Contact;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;


class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return bool
     */
    public function create()
    {
        // Update $user authorization to create $outlet here.
        $user_id=Auth::id();
        return  $user_id > 0;
    }
    public function update($user, $contact)
    {
        // Update $user authorization to create $outlet here.

        dump($contact, $user);

        return $user->id == $contact->creator_id;
    }
    public function delete(User $user, Contact $contact)
    {
        if ($user->is_Admin()) {
            return true;
        }
        else {
            return $contact->creator_id == $user->id;
        }
    }

}
