<?php

namespace App\Policies;

use App\Models\ApplicantsFreelancePost;
use App\Models\FreelancePost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ApplicantsFreelancePostPolicy
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
        $company = $user->company;


        if (
            ($seeker && $seeker->id === $freelancePost->seeker_id) ||
            ($company && $company->id === $freelancePost->company_id)
        ) {
            return true;
        }

        return $this->deny('You do not have permission to modify this applicant.');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ApplicantsFreelancePost $applicantsFreelancePost)
    {
        $seeker = $user->seeker;

        if($seeker && $seeker->id === $applicantsFreelancePost->seeker_id){
            return true;
        }
        return $this->deny('You do not have permission to delete this applicant .');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ApplicantsFreelancePost $applicantsFreelancePost): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ApplicantsFreelancePost $applicantsFreelancePost): bool
    {
        //
    }
}
