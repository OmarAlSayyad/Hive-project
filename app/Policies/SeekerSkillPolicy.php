<?php

namespace App\Policies;

use App\Models\SeekerSkill;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SeekerSkillPolicy
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
    public function view(User $user, SeekerSkill $seekerSkill): bool
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
    public function update(User $user, SeekerSkill $seekerSkill)
    {
        $seeker = $user->seeker;

        if($seeker && $seeker->id === $seekerSkill->seeker_id){
            return true;
        }
        return $this->deny('You do not have permission to update this skill.');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SeekerSkill $seekerSkill)
    {
        $seeker = $user->seeker;

        if($seeker && $seeker->id === $seekerSkill->seeker_id){
            return true;
        }
        return $this->deny('You do not have permission to delete this skill.');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SeekerSkill $seekerSkill): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SeekerSkill $seekerSkill): bool
    {
        //
    }
}
