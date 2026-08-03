<?php

namespace App\DTOs;

use App\Http\Requests\UpdateVehicleRequest;

readonly class UpdateVehicleData
{
    public function __construct(
        public ?string $vehicle_number,
        public ?string $vehicle_type,
        public ?string $brand,
        public ?string $model,
        public ?int $year,
        public ?string $color,
        public ?int $seat_capacity,
        public ?int $luggage_capacity,
        public ?array $features,
    ) {}

    public static function fromRequest(
        UpdateVehicleRequest $request
    ): self {

        return new self(
            vehicle_number: $request->input('vehicle_number'),
            vehicle_type: $request->input('vehicle_type'),
            brand: $request->input('brand'),
            model: $request->input('model'),
            year: $request->input('year'),
            color: $request->input('color'),
            seat_capacity: $request->input('seat_capacity'),
            luggage_capacity: $request->input('luggage_capacity'),
            features: $request->input('features'),
        );
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this), fn ($value) => ! is_null($value));
    }
}