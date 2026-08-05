<?php

namespace App\DTOs;

use App\Http\Requests\UpdateHotelStatusRequest;

class UpdateHotelStatusData
{
    public function __construct(
        public readonly string $status
    ) {}

    public static function fromRequest(
        UpdateHotelStatusRequest $request
    ): self {
        return new self(
            status: $request->validated('status')
        );
    }
}