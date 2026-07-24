<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\BusinessType;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'type',
        'name',
        'description',
        'phone',
        'email',
        'address',
        'latitude',
        'longitude',
        'logo',
        'is_verified',
        'is_active',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'type' => BusinessType::class,
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function jeeps()
    {
       // return $this->hasMany(Jeep::class);
    }
}
