<?php

namespace App\Policies;
use App\Outlet;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class OutletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the outlet.
     *
     * @param \App\User $user
     * @param \App\Outlet $outlet
     * @return mixed
     */
    public function view()
    {
        // Update $user authorization to view $outlet here.
        return true;
    }

    /**
     * Determine whether the user can create outlet.
     *
     * @param \App\User $user
     * @param \App\Outlet $outlet
     * @return mixed
     */
    public function create()
    {
        // Update $user authorization to create $outlet here.
        return true;
    }

    /**
     * Determine whether the user can update the outlet.
     *
     * @param \App\User $user
     * @param \App\Outlet $outlet
     * @return mixed
     */
    public function update()
    {
        // Update $user authorization to update $outlet here.
       // return true;
        return true;
    }

    /**
     * Determine whether the user can delete the outlet.
     *
     * @param \App\User $user
     * @param \App\Outlet $outlet
     * @return mixed
     */
    public function delete()
    {
        // Update $user authorization to delete $outlet here.
        return true;
    }
    public function manage_outlet()
    {
             return true;

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
