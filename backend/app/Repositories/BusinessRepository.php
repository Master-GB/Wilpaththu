<?php

namespace App\Repositories;

use App\Contracts\Repositories\BusinessRepositoryInterface;
use App\DTOs\BusinessData;
use App\Models\Business;

class BusinessRepository implements BusinessRepositoryInterface
{
    public function create(
        int $ownerId,
        BusinessData $data
    ): Business {

        return Business::create([
            'owner_id' => $ownerId,
            ...$data->toArray(),
        ]);
    }

    public function update(
        Business $business,
        BusinessData $data
    ): Business {

        $business->update(
            $data->toArray()
        );

        return $business->fresh();
    }

    public function delete(
        Business $business
    ): bool {

        return $business->delete();
    }

    public function find(int $id): ?Business
    {
        return Business::find($id);
    }

    public function all()
    {
        return Business::latest()->paginate();
    }
}
