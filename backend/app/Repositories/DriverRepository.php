<?php

namespace App\Repositories;

use App\Contracts\Repositories\DriverRepositoryInterface;
use App\Models\User;
use App\Models\DriverProfile;
use App\DTOs\UpdateDriverData;
use App\DTOs\UpdateDriverAvailabilityData;
use App\DTOs\UpdateDriverVerificationData;

class DriverRepository implements DriverRepositoryInterface
{
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

    public function updateProfile(DriverProfile $driver, UpdateDriverData $data): DriverProfile
    {
        $driver->update($data->toArray());
        return $driver->refresh();
    }

    public function updateAvailability(DriverProfile $driver, UpdateDriverAvailabilityData $data): DriverProfile
    {
        $driver->update([
        'availability' => $data->availability,
    ]);

    return $driver->refresh();
    }
    
    public function updateVerified(DriverProfile $driver, UpdateDriverVerificationData $data): DriverProfile
    {
        $driver->update([
        'verified' => $data->verified,
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