<?php

namespace App\Enum\Bank;

enum DistributionType: string
{
    case FiftyFifty = 'FiftyFifty';
    case IncomePercent = 'IncomePercent';
}
