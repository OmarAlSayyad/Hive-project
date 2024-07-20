<?php

namespace App\Policies;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ExperiencePolicy
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
    public function view(User $user, Experience $experience): bool
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
    public function update(User $user, Experience $experience)
    {
        $seeker = $user->seeker;

        if($seeker && $seeker->id === $experience->seeker_id){
            return true;
        }
        return $this->deny('You do not have permission to update this experience.');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Experience $experience)
    {
        $seeker = $user->seeker;

        if($seeker && $seeker->id === $experience->seeker_id){
            return true;
        }
        return $this->deny('You do not have permission to delete this experience.');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Experience $experience): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Experience $experience): bool
    {
        //
    }
}
