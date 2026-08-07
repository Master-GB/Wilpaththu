<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'hotel_id' => $this->hotel_id,

            'room_number' => $this->room_number,

            'room_name' => $this->room_name,

            'description' => $this->description,

            'room_type' => $this->room_type,

            'floor_number' => $this->floor_number,

            'max_adults' => $this->max_adults,

            'max_children' => $this->max_children,

            'max_occupancy' => $this->max_occupancy,

            'bed_type' => $this->bed_type,

            'bed_count' => $this->bed_count,

            'room_size' => $this->room_size,

            'room_size_unit' => $this->room_size_unit,

            'view_types' => $this->view_types,

            'bathroom_type' => $this->bathroom_type,

            'smoking_allowed' => $this->smoking_allowed,

            'pets_allowed' => $this->pets_allowed,

            'accessible_room' => $this->accessible_room,

            'amenities' => $this->amenities,

            'status' => $this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}