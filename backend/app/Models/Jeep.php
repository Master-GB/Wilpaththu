<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jeep extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'business_id',
        'driver_id',
        'registration_number',
        'brand',
        'model',
        'year',
        'color',
        'seat_capacity',
        'fuel_type',
        'transmission',
        'features',
        'description',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'year' => 'integer',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    
}