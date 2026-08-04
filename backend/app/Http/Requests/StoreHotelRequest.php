<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'hotel_name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'address' => [
                'required',
                'string',
                'max:255',
            ],

            'district' => [
                'required',
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
                'required',
                'string',
                'max:20',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
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
                'required',
                'string',
                'max:255',
            ],

            'check_out_policy' => [
                'required',
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