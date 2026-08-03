<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'business_id' => $this->business_id,

            'driver_id' => $this->driver_id,

            'vehicle_number' => $this->vehicle_number,

            'vehicle_type' => $this->vehicle_type,

            'brand' => $this->brand,

            'model' => $this->model,

            'year' => $this->year,

            'color' => $this->color,

            'seat_capacity' => $this->seat_capacity,

            'luggage_capacity' => $this->luggage_capacity,

            'features' => $this->features,

            'status' => $this->status,

            'business' => $this->whenLoaded(
                'business',
                fn () => [
                    'id' => $this->business->id,
                    'business_name' => $this->business->business_name,
                ]
            ),

            'driver' => $this->whenLoaded(
                'driver',
                fn () => [
                    'id' => $this->driver->id,
                    'name' => $this->driver->user->name,
                    'email' => $this->driver->user->email,
                ]
            ),

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}