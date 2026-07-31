<?php

namespace App\Repositories;

use App\Contracts\Repositories\JeepRepositoryInterface;
use App\Models\Jeep;
use Illuminate\Database\Eloquent\Collection;

class JeepRepository extends BaseRepository implements JeepRepositoryInterface
{
    public function __construct(Jeep $jeep)
    {
        parent::__construct($jeep);
    }

    public function getAllJeeps(): Collection
    {
        return Jeep::with([
            'business',
            'driver',
        ])->get();
    }

    public function findJeepById(int $id): ?Jeep
    {
        return Jeep::with([
            'business',
            'driver',
        ])->find($id);
    }

    public function createJeep(array $data): Jeep
    {
        return Jeep::create($data);
    }

    public function updateJeep(Jeep $jeep, array $data): Jeep
    {
        $jeep->update($data);

        return $jeep->fresh([
            'business',
            'driver',
        ]);
    }

    public function deleteJeep(Jeep $jeep): bool
    {
        return $jeep->delete();
    }

    public function assignJeepDriver(Jeep $jeep, ?int $driverId): Jeep
    {
        $jeep->update([
            'driver_id' => $driverId,
        ]);

        return $jeep->fresh([
            'business',
            'driver',
        ]);
    }

    public function changeJeepStatus(Jeep $jeep, string $status): Jeep
    {
        $jeep->update([
            'status' => $status,
        ]);

        return $jeep->fresh([
            'business',
            'driver',
        ]);
    }
}