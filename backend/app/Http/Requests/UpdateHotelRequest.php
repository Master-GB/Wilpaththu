<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'hotel_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'description' => [
                'sometimes',
                'string',
            ],

            'address' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'district' => [
                'sometimes',
                'string',
                'max:100',
            ],

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],

            'contact_number' => [
                'sometimes',
                'string',
                'max:20',
            ],

            'website' => [
                'nullable',
                'url',
                'max:255',
            ],

            'amenities' => [
                'nullable',
                'array',
            ],

            'amenities.*' => [
                'string',
                'max:100',
            ],

            'languages_spoken' => [
                'nullable',
                'array',
            ],

            'languages_spoken.*' => [
                'string',
                'max:50',
            ],

            'nearby_attractions' => [
                'nullable',
                'array',
            ],

            'nearby_attractions.*' => [
                'string',
                'max:255',
            ],

            'check_in_policy' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'check_out_policy' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'cancellation_policy' => [
                'nullable',
                'string',
            ],
        ];
    }
}