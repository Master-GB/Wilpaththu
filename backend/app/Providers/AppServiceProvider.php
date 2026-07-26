<?php

namespace App\Providers;

use App\Contracts\Repositories\BusinessRepositoryInterface;
use App\Contracts\Services\BusinessServiceInterface;
use App\Models\Business;
use App\Policies\BusinessPolicy;
use App\Repositories\BusinessRepository;
use App\Services\BusinessService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            BusinessRepositoryInterface::class,
            BusinessRepository::class
        );

        $this->app->bind(
            BusinessServiceInterface::class,
            BusinessService::class
        );
    }

    public function boot(): void
    {
        Gate::policy(
            Business::class,
            BusinessPolicy::class
        );
    }
}
