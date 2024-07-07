<?php

namespace App\Policies;

use App\Models\SeekerLanguage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeekerLanguagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SeekerLanguage $seekerLanguage): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SeekerLanguage $seekerLanguage): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SeekerLanguage $seekerLanguage): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SeekerLanguage $seekerLanguage): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SeekerLanguage $seekerLanguage): bool
    {
        //
    }
}
