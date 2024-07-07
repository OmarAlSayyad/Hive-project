<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\FreelancePost;
use App\Models\JobPost;
use App\Models\Seeker;
use App\Policies\CompanyPolicy;
use App\Policies\FreelancePostPolicy;
use App\Policies\JobPostPolicy;
use App\Policies\SeekerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{


    protected $policies = [
        Seeker::class => SeekerPolicy::class,
        Company::class => CompanyPolicy::class,
        FreelancePost::class => FreelancePostPolicy::class,
        JobPost::class => JobPostPolicy::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
      //  Company::class => CompanyPolicy::class
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        $this->registerPolicies();

    }
}
