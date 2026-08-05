<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'hotel_name',
        'slug',
        'description',
        'address',
        'district',
        'latitude',
        'longitude',
        'contact_number',
        'email',
        'website',
        'star_rating',
        'guest_rating',
        'total_reviews',
        'amenities',
        'languages_spoken',
        'nearby_attractions',
        'check_in_policy',
        'check_out_policy',
        'cancellation_policy',
        'featured_type',
        'status',
        'verified',
    ];

    protected $casts = [
        'amenities' => 'array',
        'languages_spoken' => 'array',
        'nearby_attractions' => 'array',
        'verified' => 'boolean',
        'guest_rating' => 'decimal:1',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    
    // public function images()
    // {
    //     return $this->hasMany(HotelImage::class);
    // }

    // public function bookings()
    // {
    //     return $this->hasMany(Booking::class);
    // }
}