<?php

namespace App\Contracts\Services;

use App\DTOs\StoreJeepData;
use App\DTOs\UpdateJeepData;
use App\Models\Jeep;
use Illuminate\Database\Eloquent\Collection;

interface JeepServiceInterface
{
    public function getAllJeeps(): Collection;

    public function findJeepById(int $id): Jeep;

    public function createJeep(StoreJeepData $data): Jeep;

    public function updateJeep(Jeep $jeep, UpdateJeepData $data): Jeep;

    public function deleteJeep(Jeep $jeep): bool;

    public function assignJeepDriver(Jeep $jeep, int $driverId): Jeep;

    public function removeJeepDriver(Jeep $jeep): Jeep;

    public function changeJeepStatus(Jeep $jeep, string $status): Jeep;
}