<?php

namespace App\Providers;

use App\Models\Company;
use App\Policies\CompanyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{


    protected $policies = [
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
