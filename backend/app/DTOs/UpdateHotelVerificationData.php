<?php

namespace App\DTOs;

use App\Http\Requests\UpdateHotelVerificationRequest;

class UpdateHotelVerificationData
{
    public function __construct(
        public readonly bool $verified,
    ) {}

    public static function fromRequest(
        UpdateHotelVerificationRequest $request
    ): self {
        return new self(
            verified: $request->validated('verified'),
        );
    }
}