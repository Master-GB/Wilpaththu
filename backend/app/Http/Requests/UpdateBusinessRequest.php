<?php

namespace App\Http\Requests;

use App\Enums\BusinessType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'business_name' => [
                'sometimes',
                'string',
                'max:255'
            ],

            'description' => [
                'sometimes',
                'string',
                'max:1000'
            ],

            'registration_number' => [
                'sometimes',
                Rule::unique('businesses')
                    ->ignore($this->business)
            ],

            'business_type' => [
                'sometimes',
                Rule::enum(BusinessType::class),
            ],

            'contact_number' => [
                'sometimes',
                'string'
            ],

            'email' => [
                'nullable',
                'email'
            ],

            'address' => [
                'sometimes',
                'string'
            ],

        ];
    }
}
