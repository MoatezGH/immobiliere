<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('isPromoteur', function ($user) {
            return $user->is_promoteur == 1;
        });
        Gate::define('isAgent', function ($user) {
            return $user->is_promoteur == 0;
        });
        Gate::define('isAdmin', function ($user) {
            return $user->is_admin == 1;
        });
    }
}
