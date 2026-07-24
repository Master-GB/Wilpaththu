<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::findByName('Admin');

        $admin->givePermissionTo([
            'hotel.create',
            'hotel.view',
            'hotel.update',
            'hotel.delete',

            'jeep.create',
            'jeep.view',
            'jeep.update',
            'jeep.delete',

            'guide.create',
            'guide.view',
            'guide.update',
            'guide.delete',

            'transport.create',
            'transport.view',
            'transport.update',
            'transport.delete',

            'booking.create',
            'booking.view',
            'booking.update',
            'booking.cancel',

            'user.manage',
            'role.manage',
        ]);

        Role::findByName('Hotel Owner')->givePermissionTo([
            'hotel.create',
            'hotel.view',
            'hotel.update',
            'hotel.delete',
        ]);

        Role::findByName('Jeep Driver')->givePermissionTo([
            'jeep.create',
            'jeep.view',
            'jeep.update',
            'jeep.delete',
        ]);

        Role::findByName('Tour Guide')->givePermissionTo([
            'guide.create',
            'guide.view',
            'guide.update',
            'guide.delete',
        ]);

        Role::findByName('Transport Provider')->givePermissionTo([
            'transport.create',
            'transport.view',
            'transport.update',
            'transport.delete',
        ]);

        Role::findByName('Tourist')->givePermissionTo([
            'booking.create',
            'booking.view',
            'booking.cancel',
        ]);
    }
}
