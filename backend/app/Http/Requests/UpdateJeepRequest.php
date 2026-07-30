<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJeepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jeepId = $this->route('jeep');

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
                Rule::unique('jeeps', 'registration_number')->ignore($jeepId)
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
                'required',
                Rule::in([
                    'Available',
                    'Maintenance',
                    'Inactive',
                ])
            ]
        ];
    }
}