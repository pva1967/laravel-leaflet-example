<?php

namespace App\Providers;

use App\Policies\OutletPolicy;
use App\Policies\ContactPolicy;
use App\Outlet;
use App\Contact;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Outlet::class => OutletPolicy::class,
        Contact::class => ContactPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
