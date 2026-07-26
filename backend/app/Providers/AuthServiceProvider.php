<?php

namespace App\Providers;

use App\Enums\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->hasRole(Role::ADMIN->value);
        });

        Gate::define('business-owner', function ($user) {
            return $user->hasAnyRole([
                Role::JEEP_OWNER->value,
                Role::TRANSPORT_OWNER->value,
            ]);
        });

        Gate::define('hotel', function ($user) {
            return $user->hasRole(Role::HOTEL_OWNER->value);
        });

        Gate::define('tour-guide', function ($user) {
            return $user->hasRole(Role::TOUR_GUIDE->value);
        });
    }

    protected $policies = [
    \App\Models\Business::class => \App\Policies\BusinessPolicy::class,
];
}
