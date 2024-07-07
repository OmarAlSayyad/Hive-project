<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Seeker;
use App\Policies\CompanyPolicy;
use App\Policies\SeekerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{


    protected $policies = [
        Seeker::class => SeekerPolicy::class,
        Company::class => CompanyPolicy::class,
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
