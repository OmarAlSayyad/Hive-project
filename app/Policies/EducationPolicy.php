<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EducationPolicy
{
    use HandlesAuthorization;

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
    public function view(User $user, Education $education): bool
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
    public function update(User $user, Education $education)
    {
        $seeker = $user->seeker;

        if($seeker && $seeker->id === $education->seeker_id){
            return true;
        }
        return $this->deny('You do not have permission to update this education certificate.');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Education $education)
    {
        $seeker = $user->seeker;

        if($seeker && $seeker->id === $education->seeker_id){
            return true;
        }
        return $this->deny('You do not have permission to delete this education certificate.');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Education $education): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Education $education): bool
    {
        //
    }
}
