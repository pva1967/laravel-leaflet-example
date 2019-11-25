<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Contact' => 'App\Policies\ContactPolicy',
        'App\Outlet' => 'App\Policies\OutletPolicy',
        'App\Model'  => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create', function () {
            return auth()->check();
            });
        Gate::define('update-contact', function () {

            return auth()->check();
        });

        Gate::define('manage_outlet', function () {
            return auth()->check();
        });
        Gate::define('view-post', function () {
            return auth()->check();
        });
    }
}
