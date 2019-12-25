<?php

namespace App\Policies;

use App\Cont2loc;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Cont2locPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view_post (User $user, Outlet $outlet)
    {
        if ($user->is_Admin()) {
            return true;
        }
        else {
            return $outlet->creator_id == $user->id;
        }

    }
}
