<?php

namespace App\Policies;

use Auth;
use App\User;
use App\Magazin;
use Illuminate\Auth\Access\HandlesAuthorization;

class MagazinPolicy
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

        public function before(User $user) {
        if (!Auth::check()) {
            return false;
        }
    }

    /**
     * Determine if the given user can create posts.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Magazin  $magazin
     * @return bool
     */
    public function update(User $user, Magazin $magazin)
    {
        return $user->id == $magazin->user_id;
    }
}
