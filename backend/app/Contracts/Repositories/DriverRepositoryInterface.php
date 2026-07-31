<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use App\Models\DriverProfile;

interface DriverRepositoryInterface
{
    public function createUser(array $data): User;

    public function createDriverProfile(array $data): DriverProfile;

    public function findDriverByUser(int $userId): ?DriverProfile;

    public function getBusinessDrivers(int $businessId);

    public function findById(int $id): ?DriverProfile;

    public function updateProfile(DriverProfile $driver, array $data): DriverProfile;

    public function updateAvailability(DriverProfile $driver, string $availability): DriverProfile;

    public function updateVerified(DriverProfile $driver, bool $verified): DriverProfile;

    public function deleteProfile(DriverProfile $driver): void;

    public function getAvailableDrivers(int $businessId);
}