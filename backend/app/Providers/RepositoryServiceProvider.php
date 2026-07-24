<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;

use App\Contracts\Services\AuthServiceInterface;
use App\Services\AuthService;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Repository Bindings
        |--------------------------------------------------------------------------
        */

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        /*
        |--------------------------------------------------------------------------
        | Service Bindings
        |--------------------------------------------------------------------------
        */

        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );
    }

    public function boot(): void
    {
        //
    }
}
