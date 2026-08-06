<?php

namespace App\Enums;

enum BathroomTypeEnum: string
{
    case PRIVATE = 'Private';
    case SHARED = 'Shared';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}