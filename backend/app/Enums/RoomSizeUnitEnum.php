<?php

namespace App\Enums;

enum RoomSizeUnitEnum: string
{
    case SQM = 'sqm';
    case SQFT = 'sqft';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}