<?php

namespace App\Repositories;

use App\Contracts\Repositories\VehicleRepositoryInterface;
use App\Models\Vehicle;

class VehicleRepository implements VehicleRepositoryInterface
{
    public function createVehicle(array $data): Vehicle
    {
        return Vehicle::create($data);
    }

    public function getAllVehicles()
    {
        return Vehicle::with([
            'business',
            'driver.user',
        ])->latest()->get();
    }

    public function findById(int $id): ?Vehicle
    {
        return Vehicle::with([
            'business',
            'driver.user',
        ])->find($id);
    }

    public function updateVehicle(
        Vehicle $vehicle,
        array $data
    ): Vehicle {

        $vehicle->update($data);

        return $vehicle->fresh([
            'business',
            'driver.user',
        ]);
    }

    public function deleteVehicle(
        Vehicle $vehicle
    ): void {

        $vehicle->delete();
    }

    public function assignDriver(
        Vehicle $vehicle,
        int $driverId
    ): Vehicle {

        $vehicle->update([
            'driver_id' => $driverId,
        ]);

        return $vehicle->fresh([
            'business',
            'driver.user',
        ]);
    }

    public function removeDriver(
        Vehicle $vehicle
    ): Vehicle {

        $vehicle->update([
            'driver_id' => null,
        ]);

        return $vehicle->fresh([
            'business',
            'driver.user',
        ]);
    }

    public function changeStatus(
        Vehicle $vehicle,
        string $status
    ): Vehicle {

        $vehicle->update([
            'status' => $status,
        ]);

        return $vehicle->fresh([
            'business',
            'driver.user',
        ]);
    }
}