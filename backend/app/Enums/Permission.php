<?php

namespace App\Enums;

enum Permission: string
{
    // Business
    case BUSINESS_CREATE = 'business.create';
    case BUSINESS_VIEW = 'business.view';
    case BUSINESS_UPDATE = 'business.update';
    case BUSINESS_DELETE = 'business.delete';
    case BUSINESS_VERIFY = 'business.verify';

    // Hotel
    case HOTEL_CREATE = 'hotel.create';
    case HOTEL_VIEW = 'hotel.view';
    case HOTEL_UPDATE = 'hotel.update';
    case HOTEL_DELETE = 'hotel.delete';
    case HOTEL_VERIFY = 'hotel.verify';

    // Jeep
    case JEEP_CREATE = 'jeep.create';
    case JEEP_VIEW = 'jeep.view';
    case JEEP_UPDATE = 'jeep.update';
    case JEEP_DELETE = 'jeep.delete';
    case JEEP_ASSIGN_DRIVER = 'jeep.assign-driver';

    // Vehicle
    case VEHICLE_CREATE = 'vehicle.create';
    case VEHICLE_VIEW = 'vehicle.view';
    case VEHICLE_UPDATE = 'vehicle.update';
    case VEHICLE_DELETE = 'vehicle.delete';
    case VEHICLE_ASSIGN_DRIVER = 'vehicle.assign-driver';

    // Guide
    case GUIDE_CREATE = 'guide.create';
    case GUIDE_VIEW = 'guide.view';
    case GUIDE_UPDATE = 'guide.update';
    case GUIDE_DELETE = 'guide.delete';
    case GUIDE_VERIFY = 'guide.verify';

    // Booking
    case BOOKING_CREATE = 'booking.create';
    case BOOKING_VIEW = 'booking.view';
    case BOOKING_UPDATE = 'booking.update';
    case BOOKING_CANCEL = 'booking.cancel';

    // Users
    case USER_VIEW = 'user.view';
    case USER_UPDATE = 'user.update';
    case USER_DELETE = 'user.delete';
    case USER_MANAGE = 'user.manage';

    // Roles
    case ROLE_MANAGE = 'role.manage';
    case PERMISSION_MANAGE = 'permission.manage';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
