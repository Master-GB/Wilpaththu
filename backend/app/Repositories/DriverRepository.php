<?php

namespace App\Repositories;

use App\Contracts\Repositories\DriverRepositoryInterface;
use App\Models\User;
use App\Models\DriverProfile;

class DriverRepository implements DriverRepositoryInterface
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function createDriverProfile(array $data): DriverProfile
    {
        return DriverProfile::create($data);
    }

    public function findDriverByUser(int $userId): ?DriverProfile
    {
        return DriverProfile::where('user_id', $userId)
            ->first();
    }

    public function getBusinessDrivers(int $businessId)
    {
        return DriverProfile::where('business_id', $businessId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function updateProfile(DriverProfile $driver, array $data): DriverProfile
    {
        $driver->update($data);
        return $driver->refresh();
    }

    public function updateAvailability(DriverProfile $driver, string $availability): DriverProfile
    {
        $driver->update([
        'availability' => $availability,
    ]);

        return $driver->refresh();
    }
    
    public function updateVerified(DriverProfile $driver, bool $verified): DriverProfile
    {
        $driver->update([
            'verified' => $verified,
        ]);

        return $driver->refresh();
    }

    public function deleteProfile(DriverProfile $driver): void
    {
        $driver->user()->delete();
    }

    public function findById(int $id): ?DriverProfile
    {
        return DriverProfile::with([
            'user',
            'business',
        ])->find($id);
    }

    public function getAvailableDrivers(int $businessId)
    {
        return DriverProfile::where('business_id', $businessId)
            ->where('availability', 'Available')
            ->where('verified', true)
            ->with('user')
            ->get();
    }
}