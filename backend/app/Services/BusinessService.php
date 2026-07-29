<?php

namespace App\Services;

use App\Contracts\Repositories\BusinessRepositoryInterface;
use App\Contracts\Services\BusinessServiceInterface;
use App\DTOs\BusinessData;
use App\Models\Business;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BusinessService implements BusinessServiceInterface
{
    public function __construct(
        private readonly BusinessRepositoryInterface $repository
    ) {}

    public function create(
        int $ownerId,
        BusinessData $data
    ): Business {

        return $this->repository->create(
            $ownerId,
            $data
        );
    }

    public function update(
        Business $business,
        BusinessData $data
    ): Business {

        return $this->repository->update(
            $business,
            $data
        );
    }

    public function delete(
        Business $business
    ): bool {

        return $this->repository->delete(
            $business
        );
    }

    public function all(): LengthAwarePaginator
    {
        return $this->repository->all();
    }

    public function find(int $id): ?Business
    {
        return $this->repository->find($id);
    }
}
