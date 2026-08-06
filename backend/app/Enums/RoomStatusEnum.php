<?php

namespace App\Enums;

enum RoomStatusEnum: string
{
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case MAINTENANCE = 'Maintenance';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}