<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'business_id',

        'driver_id',

        'vehicle_number',

        'vehicle_type',

        'brand',

        'model',

        'year',

        'color',

        'seat_capacity',

        'luggage_capacity',

        'features',

        'status',
    ];

    protected $casts = [

        'features' => 'array',

        'year' => 'integer',

        'seat_capacity' => 'integer',

        'luggage_capacity' => 'integer',
    ];

    /**
     * Business owner.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Assigned transport driver.
     */
    public function driver()
    {
        return $this->belongsTo(DriverProfile::class,'driver_id');
    }

    /**
     * Future bookings.
     */
    // public function bookings()
    // {
    //     return $this->hasMany(Booking::class);
    // }
}