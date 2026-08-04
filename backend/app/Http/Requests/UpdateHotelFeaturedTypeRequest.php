<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelFeaturedTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'featured_type' => [
                'required',
                'in:None,Featured,Top Pick,Recommended',
            ],
        ];
    }
}