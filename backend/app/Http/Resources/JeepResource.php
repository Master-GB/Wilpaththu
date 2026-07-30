<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JeepResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'business' => new BusinessResource(
                $this->whenLoaded('business')
            ),

            'driver' => $this->driver
                ? new UserResource($this->driver)
                : null,

            'registration_number' => $this->registration_number,

            'brand' => $this->brand,

            'model' => $this->model,

            'year' => $this->year,

            'color' => $this->color,

            'seat_capacity' => $this->seat_capacity,

            'features' => $this->features,

            'description' => $this->description,

            'status' => $this->status,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}