<?php

namespace App\DTOs;

use App\Http\Requests\UpdateHotelStarRatingRequest;

class UpdateHotelStarRatingData
{
    public function __construct(
        public readonly ?int $star_rating,
    ) {}

    public static function fromRequest(
        UpdateHotelStarRatingRequest $request
    ): self {
        return new self(
            star_rating: $request->validated('star_rating'),
        );
    }
}