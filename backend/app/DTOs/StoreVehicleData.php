<?php

namespace App\DTOs;

use App\Http\Requests\StoreVehicleRequest;

readonly class StoreVehicleData
{
    public function __construct(
        public int $business_id,
        public string $vehicle_number,
        public string $vehicle_type,
        public string $brand,
        public string $model,
        public int $year,
        public string $color,
        public int $seat_capacity,
        public ?int $luggage_capacity,
        public ?array $features,
    ) {}

    public static function fromRequest(
        StoreVehicleRequest $request
    ): self {

        return new self(
            business_id: $request->business_id,
            vehicle_number: $request->vehicle_number,
            vehicle_type: $request->vehicle_type,
            brand: $request->brand,
            model: $request->model,
            year: $request->year,
            color: $request->color,
            seat_capacity: $request->seat_capacity,
            luggage_capacity: $request->luggage_capacity,
            features: $request->features,
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}