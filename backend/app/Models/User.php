<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Business;
use App\Models\DriverProfile;
use App\Models\Jeep;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'owner_id');
    }

    public function drivenJeep()
    {
        return $this->hasOne(Jeep::class, 'driver_id');
    }

    public function drivenVehicle()
    {
        return $this->hasOne(Vehicle::class, 'driver_id');
    }

    public function driverProfile()
    {
        return $this->hasOne(DriverProfile::class);
    }
}
