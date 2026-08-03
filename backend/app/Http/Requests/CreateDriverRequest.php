<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDriverRequest extends FormRequest
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

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'license_number' => [
                'required',
                'string',
                'max:100',
                'unique:driver_profiles,license_number',
            ],

            'license_expiry_date' => [
                'required',
                'date',
                'after:today',
            ],

            'experience_years' => [
                'required',
                'integer',
                'min:0',
                'max:60',
            ],

            'languages' => [
                'nullable',
                'array',
            ],

            'languages.*' => [
                'string',
                'max:50',
            ],

            'emergency_contact' => [
                'nullable',
                'string',
                'max:15',
            ],
        ];
    }
}