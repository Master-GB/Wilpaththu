<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Hotel
            'hotel.create',
            'hotel.view',
            'hotel.update',
            'hotel.delete',

            // Jeep
            'jeep.create',
            'jeep.view',
            'jeep.update',
            'jeep.delete',

            // Guide
            'guide.create',
            'guide.view',
            'guide.update',
            'guide.delete',

            // Transport
            'transport.create',
            'transport.view',
            'transport.update',
            'transport.delete',

            // Booking
            'booking.create',
            'booking.view',
            'booking.update',
            'booking.cancel',

            // Admin
            'user.manage',
            'role.manage',
        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);

        }
    }
}
