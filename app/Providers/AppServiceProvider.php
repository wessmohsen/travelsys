<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Register Gates for permissions
        Gate::before(function ($user, $ability) {
            // Admin has all permissions
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        // Define gates based on permission slugs
        $permissions = \App\Models\Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->hasPermission($permission->slug);
            });
        }

        // Custom Blade directives for roles
        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        Blade::if('hasanyrole', function (...$roles) {
            return auth()->check() && auth()->user()->hasAnyRole(...$roles);
        });

        // Custom Blade directives for permissions
        Blade::if('haspermission', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });
    }
}
