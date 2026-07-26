<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'business_name' => $this->business_name,

            'description' => $this->description,

            'registration_number' => $this->registration_number,

            'business_type' => $this->business_type->value,

            'contact_number' => $this->contact_number,

            'email' => $this->email,

            'address' => $this->address,

            'is_verified' => $this->is_verified,

            'verified_at' => $this->verified_at?->toISOString(),

            'is_active' => $this->is_active,

            'owner' => [
                'id' => $this->owner->id,
                'name' => $this->owner->name,
                'email' => $this->owner->email,
            ],

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
