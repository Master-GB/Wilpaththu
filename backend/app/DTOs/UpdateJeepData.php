<?php

namespace App\DTOs;

use App\Http\Requests\UpdateJeepRequest;

readonly class UpdateJeepData
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
        public string $fuel_type,
        public string $transmission,
        public array $features,
        public ?string $description,
        public string $status,
    ) {}

    public static function fromRequest(UpdateJeepRequest $request): self
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
            fuel_type: $data['fuel_type'],
            transmission: $data['transmission'] ?? 'Manual',
            features: $data['features'] ?? [],
            description: $data['description'] ?? null,
            status: $data['status'],
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}