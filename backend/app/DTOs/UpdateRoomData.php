<?php

namespace App\DTOs;

use App\Http\Requests\UpdateRoomRequest;

class UpdateRoomData
{
    public function __construct(
        public readonly ?string $roomNumber,

        public readonly ?string $roomName,

        public readonly ?string $description,

        public readonly ?string $roomType,

        public readonly ?int $floorNumber,

        public readonly ?int $maxAdults,

        public readonly ?int $maxChildren,

        public readonly ?int $maxOccupancy,

        public readonly ?string $bedType,

        public readonly ?int $bedCount,

        public readonly ?float $roomSize,

        public readonly ?string $roomSizeUnit,

        public readonly ?array $viewTypes,

        public readonly ?string $bathroomType,

        public readonly ?bool $smokingAllowed,

        public readonly ?bool $petsAllowed,

        public readonly ?bool $accessibleRoom,

        public readonly ?array $amenities,

        public readonly ?string $status,
    ) {}

    public static function fromRequest(
        UpdateRoomRequest $request
    ): self {

        return new self(

            roomNumber: $request->input('room_number'),

            roomName: $request->input('room_name'),

            description: $request->input('description'),

            roomType: $request->input('room_type'),

            floorNumber: $request->input('floor_number'),

            maxAdults: $request->input('max_adults'),

            maxChildren: $request->input('max_children'),

            maxOccupancy: $request->input('max_occupancy'),

            bedType: $request->input('bed_type'),

            bedCount: $request->input('bed_count'),

            roomSize: $request->filled('room_size')
                ? (float) $request->room_size
                : null,

            roomSizeUnit: $request->input('room_size_unit'),

            viewTypes: $request->input('view_types'),

            bathroomType: $request->input('bathroom_type'),

            smokingAllowed: $request->input('smoking_allowed'),

            petsAllowed: $request->input('pets_allowed'),

            accessibleRoom: $request->input('accessible_room'),

            amenities: $request->input('amenities'),

            status: $request->input('status'),
        );
    }
}