<?php

namespace App\Policies;

use App\Models\RequiredLanguage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequiredLanguagePolicy
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
    public function view(User $user, RequiredLanguage $requiredLanguage): bool
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
    public function update(User $user, RequiredLanguage $requiredLanguage): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RequiredLanguage $requiredLanguage): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RequiredLanguage $requiredLanguage): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RequiredLanguage $requiredLanguage): bool
    {
        //
    }
}
