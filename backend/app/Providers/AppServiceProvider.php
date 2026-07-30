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
use App\Contracts\Repositories\JeepRepositoryInterface;
use App\Repositories\JeepRepository;
use App\Contracts\Services\JeepServiceInterface;
use App\Services\JeepService;

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

        $this->app->bind(
            JeepRepositoryInterface::class,
            JeepRepository::class
        );

        $this->app->bind(
            JeepServiceInterface::class,
            JeepService::class
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
