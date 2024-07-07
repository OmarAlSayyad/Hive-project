<?php

namespace App\Policies;

use App\Models\FreelancePost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class FreelancePostPolicy
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
    public function view(User $user, FreelancePost $freelancePost)
    {

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
    public function update(User $user, FreelancePost $freelancePost)
    {
        $seeker = $user->seeker;

        if (!$seeker || $seeker->id !== $freelancePost->seeker_id) {
            return $this->deny('You do not have permission to update this freelance post.');
        }

        return true;
    }





    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FreelancePost $freelancePost): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FreelancePost $freelancePost): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FreelancePost $freelancePost): bool
    {
        //
    }
}
