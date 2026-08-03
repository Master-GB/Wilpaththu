<?php

namespace App\Services;

use App\Contracts\Repositories\DriverRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\DriverServiceInterface;
use App\DTOs\CreateDriverData;
use App\Models\DriverProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\DTOs\UpdateDriverData;
use App\DTOs\UpdateDriverAvailabilityData;
use App\DTOs\UpdateDriverVerificationData;
use App\Contracts\Repositories\BusinessRepositoryInterface;
use App\Enums\BusinessType;
use App\Enums\Role;

class DriverService extends BaseService implements DriverServiceInterface
{
    public function __construct(
        private readonly DriverRepositoryInterface $drivers,
        private readonly UserRepositoryInterface $users,
        private readonly BusinessRepositoryInterface $businesses,
    ) {}

    public function createDriver(CreateDriverData $data): array
    {
        return DB::transaction(function () use ($data) {

            $temporaryPassword = Str::password(12);

            // Validate that the e‑mail is not already taken
            if ($this->users->findByEmail($data->email)) {
                throw new \Exception('A user with this e‑mail already exists.');
            }

            $business = $this->businesses->find($data->business_id);
            if (! $business) {
                 throw new \Exception('Business not found.');
            }

            if ($business->owner_id !== auth()->id()) {
                throw new \Exception('You do not own this business.');
            }

            // Create the user
            $user = $this->users->create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($temporaryPassword),
            ]);

            if ($business->business_type === BusinessType::JEEP) {
                 $user->assignRole(Role::JEEP_DRIVER->value);
            } elseif ($business->business_type === BusinessType::TRANSPORT) {
                 $user->assignRole(Role::TRANSPORT_DRIVER->value);
            }

            $driver = $this->drivers->createDriverProfile([
                'user_id' => $user->id,
                'business_id' => $data->business_id,
                'phone' => $data->phone,
                'license_number' => $data->license_number,
                'license_expiry_date' => $data->license_expiry_date,
                'experience_years' => $data->experience_years,
                'languages' => $data->languages,
                'emergency_contact' => $data->emergency_contact,
                'availability' => 'Available',
                'verified' => false,
            ]);

            return [

                'driver' => $driver->load([
                    'user',
                    'business',
                ]),

                'credentials' => [
                    'email' => $user->email,
                    'temporary_password' => $temporaryPassword,
                ],
            ];
        });
    }

    public function findDriverByUser(int $userId): ?DriverProfile
    {
        return $this->drivers->findDriverByUser($userId);
    }

    public function getBusinessDrivers(int $businessId)
    {
        $business = $this->businesses->find($businessId);
        if (! $business) {
            throw new \Exception('Business not found.');
        }

        if ($business->owner_id !== auth()->id()) {
            throw new \Exception('You do not own this business.');
        }

        return $this->drivers->getBusinessDrivers($businessId);
    }

    public function findById(int $id): ?DriverProfile
    {
        return $this->drivers->findById($id);
    }

    public function updateProfile(DriverProfile $driver, UpdateDriverData $data): DriverProfile {

        return $this->drivers->updateProfile($driver, $data);
    }

    public function updateAvailability(DriverProfile $driver, UpdateDriverAvailabilityData $data): DriverProfile {

        return $this->drivers->updateAvailability($driver, $data);
    }

    public function updateVerified(DriverProfile $driver, UpdateDriverVerificationData $data): DriverProfile {

        return $this->drivers->updateVerified($driver, $data);
    }
    public function deleteProfile(DriverProfile $driver): void {

        $this->drivers->deleteProfile($driver);
    }

    public function getAvailableDrivers(int $businessId) {

        $business = $this->businesses->find($businessId);
        if (! $business) {
            throw new \Exception('Business not found.');
        }
        return $this->drivers->getAvailableDrivers($businessId);
    }
}
