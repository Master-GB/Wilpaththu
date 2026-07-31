<?php

namespace App\Models;

use App\Enums\BusinessType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'business_name',
        'description',
        'registration_number',
        'business_type',
        'contact_number',
        'email',
        'address',
        'is_verified',
        'verified_at',
        'is_active',
    ];

    protected $casts = [
        'business_type' => BusinessType::class,
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function jeeps()
    {
        return $this->hasMany(Jeep::class);
    }

    
}
