<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
                'exists:businesses,id',
            ],

            'vehicle_number' => [
                'required',
                'string',
                'max:50',
                'unique:vehicles,vehicle_number',
            ],

            'vehicle_type' => [
                'required',
                'in:Car,SUV,Van,Mini Bus,Bus,Luxury Car',
            ],

            'brand' => [
                'required',
                'string',
                'max:100',
            ],

            'model' => [
                'required',
                'string',
                'max:100',
            ],

            'year' => [
                'required',
                'integer',
                'digits:4',
                'min:1990',
                'max:' . (date('Y') + 1),
            ],

            'color' => [
                'required',
                'string',
                'max:50',
            ],

            'seat_capacity' => [
                'required',
                'integer',
                'min:1',
            ],

            'luggage_capacity' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'features' => [
                'nullable',
                'array',
            ],

            'features.*' => [
                'string',
                'max:100',
            ],
        ];
    }
}