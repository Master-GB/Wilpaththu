<?php

namespace App\Contracts\Repositories;

use App\DTOs\BusinessData;
use App\Models\Business;

interface BusinessRepositoryInterface
{
    public function create(
        int $ownerId,
        BusinessData $data
    ): Business;

    public function update(
        Business $business,
        BusinessData $data
    ): Business;

    public function delete(
        Business $business
    ): bool;

    public function find(int $id): ?Business;

    public function all();
}
