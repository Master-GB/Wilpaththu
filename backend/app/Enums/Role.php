<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'Admin';

    case TOURIST = 'Tourist';

    case HOTEL_OWNER = 'Hotel Owner';

    case JEEP_OWNER = 'Jeep Owner';

    case JEEP_DRIVER = 'Jeep Driver';

    case TRANSPORT_OWNER = 'Transport Owner';

    case TRANSPORT_DRIVER = 'Transport Driver';

    case TOUR_GUIDE = 'Tour Guide';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
