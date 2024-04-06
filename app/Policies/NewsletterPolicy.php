<?php

namespace App\Policies;

use App\Models\Newsletter;
use Botble\ACL\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsletterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Botble\ACL\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Botble\ACL\Models\User  $user
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Newsletter $newsletter)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Botble\ACL\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Botble\ACL\Models\User  $user
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Newsletter $newsletter)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Botble\ACL\Models\User  $user
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Newsletter $newsletter)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Botble\ACL\Models\User  $user
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Newsletter $newsletter)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Botble\ACL\Models\User  $user
     * @param  \App\Models\Newsletter  $newsletter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Newsletter $newsletter)
    {
        //
    }
}
