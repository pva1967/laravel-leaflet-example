<?php

namespace App\Policies;

use App\Contact;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return bool
     */
    public function edit(User $user, Contact $contact)
    {
        // Update $user authorization to create $outlet here.
        return $contact->creator_id == $user->id;
    }


}
