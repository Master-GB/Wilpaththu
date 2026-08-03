<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'vehicle_number' => [
                'sometimes',
                'string',
                'max:50',
                'unique:vehicles,vehicle_number,' . $this->route('vehicle')->id,
            ],

            'vehicle_type' => [
                'sometimes',
                'in:Car,SUV,Van,Mini Bus,Bus,Luxury Car',
            ],

            'brand' => [
                'sometimes',
                'string',
                'max:100',
            ],

            'model' => [
                'sometimes',
                'string',
                'max:100',
            ],

            'year' => [
                'sometimes',
                'integer',
                'digits:4',
                'min:1990',
                'max:' . (date('Y') + 1),
            ],

            'color' => [
                'sometimes',
                'string',
                'max:50',
            ],

            'seat_capacity' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'luggage_capacity' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'features' => [
                'sometimes',
                'array',
            ],

            'features.*' => [
                'string',
                'max:100',
            ],
        ];
    }
}