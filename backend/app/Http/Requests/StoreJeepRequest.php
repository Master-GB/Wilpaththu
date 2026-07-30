<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJeepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'business_id' => [
                'required',
                'exists:businesses,id'
            ],

            'driver_id' => [
                'nullable',
                'exists:users,id'
            ],

            'registration_number' => [
                'required',
                'string',
                'max:50',
                'unique:jeeps,registration_number'
            ],

            'brand' => [
                'required',
                'string',
                'max:100'
            ],

            'model' => [
                'required',
                'string',
                'max:100'
            ],

            'year' => [
                'required',
                'integer',
                'min:1990',
                'max:' . date('Y')
            ],

            'color' => [
                'nullable',
                'string',
                'max:50'
            ],

            'seat_capacity' => [
                'required',
                'integer',
                'min:2',
                'max:12'
            ],

            'fuel_type' => [
                'required',
                Rule::in([
                    'Petrol',
                    'Diesel',
                    'Hybrid',
                    'Electric',
                ])
            ],

            'transmission' => [
                'nullable',
                Rule::in([
                    'Manual',
                    'Automatic',
                ])
            ],

            'features' => [
                'nullable',
                'array'
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'Available',
                    'Maintenance',
                    'Inactive',
                ])
            ]
        ];
    }
}