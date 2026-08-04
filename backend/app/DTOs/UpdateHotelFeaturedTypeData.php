<?php

namespace App\DTOs;

use App\Http\Requests\UpdateHotelFeaturedTypeRequest;

class UpdateHotelFeaturedTypeData
{
    public function __construct(
        public readonly string $featured_type,
    ) {}

    public static function fromRequest(
        UpdateHotelFeaturedTypeRequest $request
    ): self {
        return new self(
            featured_type: $request->validated('featured_type'),
        );
    }
}