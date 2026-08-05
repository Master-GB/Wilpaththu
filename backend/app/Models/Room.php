<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'hotel_id',

        'room_number',

        'room_name',

        'description',

        'room_type',

        'floor_number',

        'max_adults',

        'max_children',

        'max_occupancy',

        'bed_type',

        'bed_count',

        'room_size',

        'room_size_unit',

        'view_types',

        'bathroom_type',

        'smoking_allowed',

        'pets_allowed',

        'accessible_room',

        'amenities',

        'status',
    ];

    protected function casts(): array
    {
        return [

            'view_types' => 'array',

            'amenities' => 'array',

            'smoking_allowed' => 'boolean',

            'pets_allowed' => 'boolean',

            'accessible_room' => 'boolean',
        ];
    }

    public function hotel()
    {
        return $this->belongsTo(
            Hotel::class
        );
    }
}