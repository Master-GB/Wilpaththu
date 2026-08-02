<?php

namespace App\DTOs;

use App\Http\Requests\UpdateDriverAvailabilityRequest;

readonly class UpdateDriverAvailabilityData
{
    public function __construct(
        public string $availability,
    ) {}

    public static function fromRequest(
        UpdateDriverAvailabilityRequest $request
    ): self {

        return new self(
            availability: $request->availability,
        );
    }
}