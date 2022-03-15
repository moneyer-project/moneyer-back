<?php

namespace App\Enum\Bank;

enum DistributionType: string
{
    case FiftyFifty = 'FiftyFifty';
    case IncomePercent = 'IncomePercent';

    public static function get(string $value): DistributionType
    {
        return match ($value) {
            'FiftyFifty' => self::FiftyFifty,
            'IncomePercent' => self::IncomePercent
        };
    }
}
