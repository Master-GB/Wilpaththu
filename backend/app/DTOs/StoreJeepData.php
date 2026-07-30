<?php

namespace App\DTOs;

use App\Http\Requests\StoreJeepRequest;

readonly class StoreJeepData
{
    public function __construct(
        public int $business_id,
        public ?int $driver_id,
        public string $registration_number,
        public string $brand,
        public string $model,
        public int $year,
        public ?string $color,
        public int $seat_capacity,
        public array $features,
        public ?string $description,
        public string $status,
    ) {}

    public static function fromRequest(StoreJeepRequest $request): self
    {
        $data = $request->validated();

        return new self(
            business_id: $data['business_id'],
            driver_id: $data['driver_id'] ?? null,
            registration_number: $data['registration_number'],
            brand: $data['brand'],
            model: $data['model'],
            year: $data['year'],
            color: $data['color'] ?? null,
            seat_capacity: $data['seat_capacity'],
            features: $data['features'] ?? [],
            description: $data['description'] ?? null,
            status: $data['status'] ?? 'Available',
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}