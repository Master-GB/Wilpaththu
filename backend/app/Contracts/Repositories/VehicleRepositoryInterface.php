<?php

namespace App\Contracts\Repositories;

use App\Models\Vehicle;

interface VehicleRepositoryInterface
{
    public function createVehicle(array $data): Vehicle;

    public function getAllVehicles();

    public function findById(int $id): ?Vehicle;

    public function updateVehicle(Vehicle $vehicle,array $data): Vehicle;

    public function deleteVehicle(Vehicle $vehicle): void;

    public function assignDriver(Vehicle $vehicle,int $driverId): Vehicle;

    public function removeDriver(Vehicle $vehicle): Vehicle;

    public function changeStatus(Vehicle $vehicle,string $status): Vehicle;

    public function getByBusiness(int $businessId);

}