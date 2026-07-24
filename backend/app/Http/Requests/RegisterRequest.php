<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Role;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
  public function rules(): array
{
    return [

        'name' => ['required', 'string', 'max:255'],

        'email' => ['required', 'email', 'unique:users,email'],

        'password' => ['required', 'confirmed', 'min:8'],

        'role' => [
            'required',
            Rule::in([
                Role::TOURIST->value,
                Role::HOTEL_OWNER->value,
                Role::JEEP_OWNER->value,
                Role::TRANSPORT_OWNER->value,
                Role::TOUR_GUIDE->value,
            ]),
        ],

    ];
}
}
