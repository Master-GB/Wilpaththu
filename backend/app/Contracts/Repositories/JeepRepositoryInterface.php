<?php

namespace App\Contracts\Repositories;

use App\Models\Jeep;
use Illuminate\Database\Eloquent\Collection;

interface JeepRepositoryInterface
{
    public function getAllJeeps(): Collection;

    public function findJeepById(int $id): ?Jeep;

    public function createJeep(array $data): Jeep;

    public function updateJeep(Jeep $jeep, array $data): Jeep;

    public function deleteJeep(Jeep $jeep): bool;

    public function assignJeepDriver(Jeep $jeep, ?int $driverId): Jeep;

    public function changeJeepStatus(Jeep $jeep, string $status): Jeep;
    
    public function getByBusiness(int $businessId);

}