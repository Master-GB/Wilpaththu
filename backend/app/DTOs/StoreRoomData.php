<?php

namespace App\DTOs;

use App\Http\Requests\StoreRoomRequest;

class StoreRoomData
{
    public function __construct(

        public readonly string $roomNumber,

        public readonly string $roomName,

        public readonly ?string $description,

        public readonly string $roomType,

        public readonly int $floorNumber,

        public readonly int $maxAdults,

        public readonly int $maxChildren,

        public readonly int $maxOccupancy,

        public readonly string $bedType,

        public readonly int $bedCount,

        public readonly ?float $roomSize,

        public readonly string $roomSizeUnit,

        public readonly ?array $viewTypes,

        public readonly string $bathroomType,

        public readonly bool $smokingAllowed,

        public readonly bool $petsAllowed,

        public readonly bool $accessibleRoom,

        public readonly ?array $amenities,

        public readonly ?string $status = null,
    ) {}

    public static function fromRequest(
        StoreRoomRequest $request
    ): self {

        return new self(

            roomNumber: $request->string('room_number')->toString(),

            roomName: $request->string('room_name')->toString(),

            description: $request->input('description'),

            roomType: $request->string('room_type')->toString(),

            floorNumber: $request->integer('floor_number'),

            maxAdults: $request->integer('max_adults'),

            maxChildren: $request->integer('max_children'),

            maxOccupancy: $request->integer('max_occupancy'),

            bedType: $request->string('bed_type')->toString(),

            bedCount: $request->integer('bed_count'),

            roomSize: $request->filled('room_size')
                ? (float) $request->room_size
                : null,

            roomSizeUnit: $request->string('room_size_unit')->toString(),

            viewTypes: $request->input('view_types'),

            bathroomType: $request->string('bathroom_type')->toString(),

            smokingAllowed: $request->boolean('smoking_allowed'),

            petsAllowed: $request->boolean('pets_allowed'),

            accessibleRoom: $request->boolean('accessible_room'),

            amenities: $request->input('amenities'),

            status: $request->filled('status') ? $request->string('status')->toString() : null,
        );
    }
}