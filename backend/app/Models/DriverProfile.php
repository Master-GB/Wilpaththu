<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverProfile extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',

        'business_id',

        'license_number',

        'license_expiry_date',

        'experience_years',

        'languages',

        'phone',

        'emergency_contact',

        'availability',

        'verified',
    ];

    protected $casts = [

        'languages' => 'array',

        'license_expiry_date' => 'date',

        'verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function drivenJeeps()
    {
        return $this->hasOne(Jeep::class,'driver_id');
    }

    public function drivenVehicles()
    {
        return $this->hasOne(Vehicle::class,'driver_id');
    }
    
}