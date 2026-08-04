<?php

namespace App\DTOs;

use App\Http\Requests\StoreHotelRequest;

class StoreHotelData
{
    public function __construct(
        public readonly string $hotel_name,
        public readonly string $description,
        public readonly string $address,
        public readonly string $district,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly string $contact_number,
        public readonly string $email,
        public readonly ?string $website,
        public readonly ?array $amenities,
        public readonly ?array $languages_spoken,
        public readonly ?array $nearby_attractions,
        public readonly string $check_in_policy,
        public readonly string $check_out_policy,
        public readonly ?string $cancellation_policy,
    ) {}

    public static function fromRequest(
        StoreHotelRequest $request
    ): self {
        return new self(
            hotel_name: $request->validated('hotel_name'),
            description: $request->validated('description'),
            address: $request->validated('address'),
            district: $request->validated('district'),
            latitude: $request->validated('latitude'),
            longitude: $request->validated('longitude'),
            contact_number: $request->validated('contact_number'),
            email: $request->validated('email'),
            website: $request->validated('website'),
            amenities: $request->validated('amenities'),
            languages_spoken: $request->validated('languages_spoken'),
            nearby_attractions: $request->validated('nearby_attractions'),
            check_in_policy: $request->validated('check_in_policy'),
            check_out_policy: $request->validated('check_out_policy'),
            cancellation_policy: $request->validated('cancellation_policy'),
        );
    }
}