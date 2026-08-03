<?php

namespace App\DTOs;

use App\Http\Requests\UpdateVehicleStatusRequest;

readonly class UpdateVehicleStatusData
{
    public function __construct(
        public string $status,
    ) {}

    public static function fromRequest(
        UpdateVehicleStatusRequest $request
    ): self {

        return new self(
            status: $request->status,
        );
    }
}