<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('access-admin', function ($user) {
            return $user->role === 'admin'
                ? \Illuminate\Auth\Access\Response::allow()
                : \Illuminate\Auth\Access\Response::deny('Only admins can access this area.');
        });

        Gate::define('access-manajer', function ($user) {
            return $user->role === 'manajer'
                ? \Illuminate\Auth\Access\Response::allow()
                : \Illuminate\Auth\Access\Response::deny('Only managers can access this area.');
        });

        Gate::define('access-kasir', function ($user) {
            return $user->role === 'kasir'
                ? \Illuminate\Auth\Access\Response::allow()
                : \Illuminate\Auth\Access\Response::deny('Only cashiers can access this area.');
        });
    }
}
