<?php

namespace App\Services;

use App\Contracts\Repositories\BusinessRepositoryInterface;
use App\Contracts\Repositories\DriverRepositoryInterface;
use App\Contracts\Repositories\VehicleRepositoryInterface;
use App\Contracts\Services\VehicleServiceInterface;
use App\DTOs\StoreVehicleData;
use App\DTOs\UpdateVehicleData;
use App\DTOs\UpdateVehicleStatusData;
use App\Models\Vehicle;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VehicleService implements VehicleServiceInterface
{
    public function __construct(
        private readonly VehicleRepositoryInterface $vehicles,
        private readonly BusinessRepositoryInterface $businesses,
        private readonly DriverRepositoryInterface $drivers,
    ) {}

    public function createVehicle(StoreVehicleData $data): Vehicle {

        $business = $this->businesses->find(
            $data->business_id
        );

        if (! $business) {
            throw new HttpException(
                404,
                'Business not found.'
            );
        }

        if ($business->owner_id !== auth()->id()) {
            throw new HttpException(
                403,
                'You do not own this business.'
            );
        }

        return $this->vehicles->createVehicle(
            $data->toArray()
        );
    }

    public function getAllVehicles() {
        return $this->vehicles->getAllVehicles();
    }

    public function findVehicleById(int $id): ?Vehicle {

        return $this->vehicles->findById($id);
    }

    public function updateVehicle(Vehicle $vehicle,UpdateVehicleData $data): Vehicle {

        return $this->vehicles->updateVehicle(
            $vehicle,
            $data->toArray()
        );
    }

    public function deleteVehicle(Vehicle $vehicle): void {

        $this->vehicles->deleteVehicle($vehicle);
    }

    public function assignDriver(Vehicle $vehicle,int $driverId): Vehicle {

        $driver = $this->drivers->findById($driverId);

        if (! $driver) {
            throw new HttpException(
                404,
                'Driver not found.'
            );
        }

        if ($driver->business_id !== $vehicle->business_id) {
            throw new HttpException(
                403,
                'Driver does not belong to this business.'
            );
        }

        if (! $driver->user->hasRole('Transport Driver')) {
            throw new HttpException(
                403,
                'Selected user is not a transport driver.'
            );
        }

        if ($driver->drivenVehicles()->exists()) {
            throw new HttpException(
                422,
                'Driver is already assigned to a vehicle.'
            );
        }

        return $this->vehicles->assignDriver(
            $vehicle,
            $driverId
        );
    }

    public function removeDriver(Vehicle $vehicle): Vehicle {

        return $this->vehicles->removeDriver($vehicle);
    }

    public function changeStatus(Vehicle $vehicle,UpdateVehicleStatusData $data): Vehicle {

        return $this->vehicles->changeStatus(
            $vehicle,
            $data->status
        );
    }

    public function getVehiclesByBusiness(int $businessId){
        return $this->vehicles->getByBusiness($businessId);
    }
}
