<?php

namespace App\Contracts\Services;

use App\DTOs\StoreVehicleData;
use App\DTOs\UpdateVehicleData;
use App\DTOs\UpdateVehicleStatusData;
use App\Models\Vehicle;

interface VehicleServiceInterface
{
    public function createVehicle(
        StoreVehicleData $data
    ): Vehicle;

    public function getAllVehicles();

    public function findVehicleById(
        int $id
    ): ?Vehicle;

    public function updateVehicle(
        Vehicle $vehicle,
        UpdateVehicleData $data
    ): Vehicle;

    public function deleteVehicle(
        Vehicle $vehicle
    ): void;

    public function assignDriver(
        Vehicle $vehicle,
        int $driverId
    ): Vehicle;

    public function removeDriver(
        Vehicle $vehicle
    ): Vehicle;

    public function changeStatus(
        Vehicle $vehicle,
        UpdateVehicleStatusData $data
    ): Vehicle;

    public function getVehiclesByBusiness(int $businessId);

}