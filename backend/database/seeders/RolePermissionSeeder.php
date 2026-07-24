<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role as RoleModel;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        RoleModel::findByName(Role::ADMIN->value)
            ->syncPermissions(
                PermissionModel::pluck('name')->toArray()
            );

        /*
        |--------------------------------------------------------------------------
        | Tourist
        |--------------------------------------------------------------------------
        */

        RoleModel::findByName(Role::TOURIST->value)
            ->syncPermissions([
                Permission::BOOKING_CREATE->value,
                Permission::BOOKING_VIEW->value,
                Permission::BOOKING_CANCEL->value,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Hotel Owner
        |--------------------------------------------------------------------------
        */

        RoleModel::findByName(Role::HOTEL_OWNER->value)
            ->syncPermissions([
                Permission::HOTEL_CREATE->value,
                Permission::HOTEL_VIEW->value,
                Permission::HOTEL_UPDATE->value,
                Permission::HOTEL_DELETE->value,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Jeep Owner
        |--------------------------------------------------------------------------
        */

        RoleModel::findByName(Role::JEEP_OWNER->value)
            ->syncPermissions([
                Permission::BUSINESS_CREATE->value,
                Permission::BUSINESS_VIEW->value,
                Permission::BUSINESS_UPDATE->value,
                Permission::BUSINESS_DELETE->value,

                Permission::JEEP_CREATE->value,
                Permission::JEEP_VIEW->value,
                Permission::JEEP_UPDATE->value,
                Permission::JEEP_DELETE->value,
                Permission::JEEP_ASSIGN_DRIVER->value,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Jeep Driver
        |--------------------------------------------------------------------------
        */

        RoleModel::findByName(Role::JEEP_DRIVER->value)
            ->syncPermissions([
                Permission::JEEP_VIEW->value,
                //Permission::BOOKING_VIEW->value,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Transport Owner
        |--------------------------------------------------------------------------
        */

        RoleModel::findByName(Role::TRANSPORT_OWNER->value)
            ->syncPermissions([
                Permission::BUSINESS_CREATE->value,
                Permission::BUSINESS_VIEW->value,
                Permission::BUSINESS_UPDATE->value,
                Permission::BUSINESS_DELETE->value,

                Permission::VEHICLE_CREATE->value,
                Permission::VEHICLE_VIEW->value,
                Permission::VEHICLE_UPDATE->value,
                Permission::VEHICLE_DELETE->value,
                Permission::VEHICLE_ASSIGN_DRIVER->value,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Transport Driver
        |--------------------------------------------------------------------------
        */

        RoleModel::findByName(Role::TRANSPORT_DRIVER->value)
            ->syncPermissions([
                Permission::VEHICLE_VIEW->value,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Tour Guide
        |--------------------------------------------------------------------------
        */

        RoleModel::findByName(Role::TOUR_GUIDE->value)
            ->syncPermissions([
                Permission::GUIDE_CREATE->value,
                Permission::GUIDE_VIEW->value,
                Permission::GUIDE_UPDATE->value,
                Permission::GUIDE_DELETE->value,
            ]);
    }
}
