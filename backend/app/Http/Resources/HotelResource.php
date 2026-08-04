<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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

            'owner' => [
                'id' => $this->owner?->id,
                'name' => $this->owner?->name,
            ],

            'hotel_name' => $this->hotel_name,
            'slug' => $this->slug,
            'description' => $this->description,

            'address' => $this->address,
            'district' => $this->district,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'website' => $this->website,

            'star_rating' => $this->star_rating,
            'guest_rating' => $this->guest_rating,
            'total_reviews' => $this->total_reviews,

            'amenities' => $this->amenities,
            'languages_spoken' => $this->languages_spoken,
            'nearby_attractions' => $this->nearby_attractions,

            'check_in_policy' => $this->check_in_policy,
            'check_out_policy' => $this->check_out_policy,
            'cancellation_policy' => $this->cancellation_policy,

            'featured_type' => $this->featured_type,
            'status' => $this->status,
            'verified' => $this->verified,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}