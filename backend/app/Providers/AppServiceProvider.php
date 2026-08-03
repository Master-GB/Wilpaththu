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
use App\Policies\JeepPolicy;
use App\Models\Jeep;
use App\Contracts\Repositories\DriverRepositoryInterface;
use App\Repositories\DriverRepository;
use App\Models\DriverProfile;
use App\Contracts\Services\DriverServiceInterface;
use App\Services\DriverService;
use App\Policies\DriverPolicy;
use App\Contracts\Repositories\VehicleRepositoryInterface;
use App\Repositories\VehicleRepository;
use App\Contracts\Services\VehicleServiceInterface;
use App\Services\VehicleService;
use App\Models\Vehicle;
use App\Policies\VehiclePolicy;

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

        $this->app->bind(
            DriverRepositoryInterface::class,
            DriverRepository::class
        );

        $this->app->bind(
            DriverServiceInterface::class,
            DriverService::class
        );

        $this->app->bind(
            VehicleRepositoryInterface::class,
            VehicleRepository::class
        );

        $this->app->bind(
            VehicleServiceInterface::class,
            VehicleService::class
        );
    }

    public function boot(): void
    {
        Gate::policy(Business::class, BusinessPolicy::class);

        Gate::policy(Jeep::class, JeepPolicy::class);

        Gate::policy(DriverProfile::class,DriverPolicy::class);

        Gate::policy(Vehicle::class, VehiclePolicy::class);

    }
}
