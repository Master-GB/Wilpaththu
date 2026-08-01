<?php

namespace App\DTOs;

use App\Http\Requests\UpdateDriverVerificationRequest;

readonly class UpdateDriverVerificationData
{
    public function __construct(
        public bool $verified,
    ) {}

    public static function fromRequest(
        UpdateDriverVerificationRequest $request
    ): self {

        return new self(
            verified: $request->boolean('verified'),
        );
    }
}