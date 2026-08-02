<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'business_id' => $this->business_id,

            'user_id' => $this->user_id,

            'name' => $this->user?->name,

            'email' => $this->user?->email,

            'phone' => $this->phone,

            'license_number' => $this->license_number,

            'license_expiry_date' => $this->license_expiry_date?->format('Y-m-d'),

            'experience_years' => $this->experience_years,

            'languages' => $this->languages,

            'emergency_contact' => $this->emergency_contact,

            'availability' => $this->availability,

            'verified' => $this->verified,

            'business' => new BusinessResource(
                $this->whenLoaded('business')
            ),

           'created_at' => $this->created_at?->format('Y-m-d H:i:s'),

           'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}