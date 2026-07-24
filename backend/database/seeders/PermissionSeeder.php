<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            //Buisness
            'business.create',
            'business.view',
            'business.update',
            'business.delete',
            'business.verify',


            // Hotel
            'hotel.create',
            'hotel.view',
            'hotel.update',
            'hotel.delete',
            'hotel.verify',

            // Jeep
            'jeep.create',
            'jeep.view',
            'jeep.update',
            'jeep.delete',
            'jeep.assign-driver',

            // Guide
            'guide.create',
            'guide.view',
            'guide.update',
            'guide.delete',
            'guide.verify',

            // Transport
            'vehicle.create',
            'vehicle.view',
            'vehicle.update',
            'vehicle.delete',
            'vehicle.assign-driver',

            // Booking
            'booking.create',
            'booking.view',
            'booking.update',
            'booking.cancel',
            //'booking.approve',
            //'booking.reject',

            // Admin
            'user.manage',
            'role.manage',
            'permission.manage',
        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);

        }
    }
}
