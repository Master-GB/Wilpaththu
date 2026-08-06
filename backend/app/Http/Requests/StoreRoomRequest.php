<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\BedTypeEnum;
use App\Enums\RoomTypeEnum;
use App\Enums\RoomStatusEnum;
use App\Enums\BathroomTypeEnum;
use App\Enums\RoomSizeUnitEnum;

class StoreRoomRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'room_number' => [
                'required',
                'string',
                'max:50',
            ],

            'room_name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'room_type' => [
                'required',
                Rule::enum(RoomTypeEnum::class),
            ],

            'floor_number' => [
                'required',
                'integer',
                'min:1',
            ],

            'max_adults' => [
                'required',
                'integer',
                'min:1',
            ],

            'max_children' => [
                'required',
                'integer',
                'min:0',
            ],

            'max_occupancy' => [
                'required',
                'integer',
                'min:1',
            ],

            'bed_type' => [
                'required',
                Rule::enum(BedTypeEnum::class),
            ],

            'bed_count' => [
                'required',
                'integer',
                'min:1',
            ],

            'room_size' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'room_size_unit' => [
                'required_with:room_size',
                Rule::enum(RoomSizeUnitEnum::class),
            ],

            'view_types' => [
                'nullable',
                'array',
            ],

            'view_types.*' => [
                'string',
                'max:100',
            ],

            'bathroom_type' => [
                'required',
                Rule::enum(BathroomTypeEnum::class),
            ],

            'smoking_allowed' => [
                'required',
                'boolean',
            ],

            'pets_allowed' => [
                'required',
                'boolean',
            ],

            'accessible_room' => [
                'required',
                'boolean',
            ],

            'amenities' => [
                'nullable',
                'array',
            ],

            'amenities.*' => [
                'string',
                'max:100',
            ],

            'status' => [
                'sometimes',
                Rule::enum(RoomStatusEnum::class),
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'room_size_unit.required_with' =>
                'The room size unit is required when room size is provided.',
        ];
    }
}