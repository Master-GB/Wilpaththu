<?php

namespace App\Enums;

enum BedTypeEnum: string
{
    case SINGLE = 'Single';
    case DOUBLE = 'Double';
    case QUEEN = 'Queen';
    case KING = 'King';
    case BUNK = 'Bunk';
    case SOFA_BED = 'Sofa Bed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}