<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {

     // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

    Role::findByName('Admin')->syncPermissions(
    Permission::pluck('name')->toArray()
);

        Role::findByName('Hotel Owner')->syncPermissions([
            'business.create',
            'business.view',
            'business.update',
            'business.delete',

            'hotel.create',
            'hotel.view',
            'hotel.update',
            'hotel.delete',
        ]);

        Role::findByName('Jeep Owner')->syncPermissions([

            'business.create',
            'business.view',
            'business.update',
            'business.delete',

            'jeep.create',
            'jeep.view',
            'jeep.update',
            'jeep.delete',
            'jeep.assign-driver',
        ]);

        Role::findByName('Jeep Driver')->syncPermissions([
            'jeep.view',
        ]);

        Role::findByName('Transport Owner')->syncPermissions([
            'business.create',
            'business.view',
            'business.update',
            'business.delete',

            'vehicle.create',
            'vehicle.view',
            'vehicle.update',
            'vehicle.delete',
            'vehicle.assign-driver',
        ]);

        Role::findByName('Tour Guide')->syncPermissions([
            'guide.create',
            'guide.view',
            'guide.update',
            'guide.delete',
        ]);

        Role::findByName('Transport Driver')->syncPermissions([
            'vehicle.view',
        ]);

        Role::findByName('Tourist')->syncPermissions([
            'booking.create',
            'booking.view',
            'booking.cancel',
        ]);
    }
}
