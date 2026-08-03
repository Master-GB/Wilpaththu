<?php

namespace App\Services;

use App\Contracts\Repositories\BusinessRepositoryInterface;
use App\Contracts\Repositories\JeepRepositoryInterface;
use App\Contracts\Services\JeepServiceInterface;
use App\DTOs\StoreJeepData;
use App\DTOs\UpdateJeepData;
use App\Models\Jeep;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class JeepService extends BaseService implements JeepServiceInterface
{
    public function __construct(
        private readonly JeepRepositoryInterface $jeeps,
        private readonly BusinessRepositoryInterface $businesses,
    ) {}

    public function getAllJeeps(): Collection{
        return $this->jeeps->getAllJeeps();
    }

    public function findJeepById(int $id): Jeep{
        $jeep = $this->jeeps->findJeepById($id);

        if (! $jeep) {
            throw ValidationException::withMessages([
                'jeep' => 'Jeep not found.',
            ]);
        }

        return $jeep;
    }

    public function createJeep(StoreJeepData $data): Jeep{
        $business = $this->businesses->find($data->business_id);

        if (! $business) {
            throw ValidationException::withMessages([
                'business' => 'Business not found.',
            ]);
        }

        if ($business->owner_id !== auth()->id()) {
            throw new HttpException(
                403,
                'You do not own this business.'
            );
        }

        return $this->jeeps->createJeep($data->toArray());
    }

    public function updateJeep(Jeep $jeep, UpdateJeepData $data): Jeep{
        return $this->jeeps->updateJeep(
            $jeep,
            $data->toArray()
        );
    }

    public function deleteJeep(Jeep $jeep): bool{
        return $this->jeeps->deleteJeep($jeep);
    }

    public function assignJeepDriver(Jeep $jeep, int $driverId): Jeep{
        $driver = User::findOrFail($driverId);

        if (! $driver) {
            throw new HttpException(
                404,
                'Driver not found.'
            );
        }

        if ($driver->business_id !== $jeeps->business_id) {
            throw new HttpException(
                403,
                'Driver does not belong to this business.'
            );
        }

        if (! $driver->hasRole('Jeep Driver')) {
            throw ValidationException::withMessages([
                'driver_id' => 'Selected user is not a Jeep Driver.',
            ]);
        }

        $alreadyAssigned = Jeep::where('driver_id', $driverId)
            ->where('id', '!=', $jeep->id)
            ->exists();

        if ($alreadyAssigned) {
            throw ValidationException::withMessages([
                'driver_id' => 'Driver is already assigned to another jeep.',
            ]);
        }

        return $this->jeeps->assignJeepDriver(
            $jeep,
            $driverId
        );
    }

    public function removeJeepDriver(Jeep $jeep): Jeep{
        return $this->jeeps->assignJeepDriver(
            $jeep,
            null
        );
    }

    public function changeJeepStatus(Jeep $jeep, string $status): Jeep{
        return $this->jeeps->changeJeepStatus(
            $jeep,
            $status
        );
    }

    public function getJeepsByBusiness(int $businessId) {
        return $this->jeeps->getByBusiness($businessId);
    }

}