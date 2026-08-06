<?php

namespace App\Enums;

enum RoomTypeEnum: string
{
    case SINGLE = 'Single';
    case DOUBLE = 'Double';
    case TWIN = 'Twin';
    case TRIPLE = 'Triple';
    case FAMILY = 'Family';
    case SUITE = 'Suite';
    case DORMITORY = 'Dormitory';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}