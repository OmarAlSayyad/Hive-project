<?php

namespace App\Policies;

use App\Models\FavoriteFreelance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FavoriteFreelancePolicy
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
    public function view(User $user, FavoriteFreelance $favoriteFreelance): bool
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
    public function update(User $user, FavoriteFreelance $favoriteFreelance): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FavoriteFreelance $favoriteFreelance)
    {
        $seeker = $user->seeker;

        if($seeker && $seeker->id === $favoriteFreelance->seeker_id){
            return true;
        }
        return $this->deny('You do not have permission to delete this freelance post .');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FavoriteFreelance $favoriteFreelance): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FavoriteFreelance $favoriteFreelance): bool
    {
        //
    }
}
