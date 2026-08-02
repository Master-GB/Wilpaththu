<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'phone' => [
                'sometimes',
                'string',
                'max:20',
            ],

            'license_number' => [
                'sometimes',
                'string',
                'max:50',
            ],

            'license_expiry_date' => [
                'sometimes',
                'date',
            ],

            'experience_years' => [
                'sometimes',
                'integer',
                'min:0',
                'max:60',
            ],

            'languages' => [
                'sometimes',
                'array',
            ],

            'languages.*' => [
                'string',
                'max:50',
            ],

            'emergency_contact' => [
                'sometimes',
                'string',
                'max:255',
            ],
        ];
    }
}