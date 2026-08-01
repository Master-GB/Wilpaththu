<?php

namespace App\Contracts\Services;

use App\DTOs\CreateDriverData;
use App\DTOs\UpdateDriverData;
use App\DTOs\UpdateDriverAvailabilityData;
use App\DTOs\UpdateDriverVerificationData;
use App\Models\DriverProfile;

interface DriverServiceInterface
{
    public function createDriver(CreateDriverData $data): array;

    public function findDriverByUser(int $userId): ?DriverProfile;

    public function getBusinessDrivers(int $businessId);

    public function findById(int $id): ?DriverProfile;

    public function updateProfile(DriverProfile $driver,UpdateDriverData $data): DriverProfile;

    public function updateAvailability(DriverProfile $driver,UpdateDriverAvailabilityData $data): DriverProfile;

    public function updateVerified(DriverProfile $driver,UpdateDriverVerificationData $data): DriverProfile;

    public function deleteProfile(DriverProfile $driver): void;

    public function getAvailableDrivers(int $businessId);
    
}