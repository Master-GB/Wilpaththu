<?php

namespace App\Contracts\Services;

use App\DTOs\BusinessData;
use App\Models\Business;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BusinessServiceInterface
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

    public function all(): LengthAwarePaginator;

    public function find(int $id): ?Business;
}
