<?php

namespace App\Http\Requests;

use App\Enums\BusinessType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'business_name' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'required',
                'string',
                'max:1000'
            ],

            'registration_number' => [
                'required',
                'string',
                'max:100',
                'unique:businesses'
            ],

            'business_type' => [
                'required',
                Rule::enum(BusinessType::class),
            ],

            'contact_number' => [
                'required',
                'string',
                'max:20'
            ],

            'email' => [
                'nullable',
                'email'
            ],

            'address' => [
                'required',
                'string'
            ],

        ];
    }
}
