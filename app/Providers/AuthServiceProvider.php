<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
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
        Passport::routes();
        Passport::loadKeysFrom('/secret-keys/oauth');

        Gate::define('manage_outlet', function () {
            return auth()->check();
            });
        Gate::define('view-post', function ($user, $post) {
            return $user->id == $post->creator_id;
        });
    }
}
