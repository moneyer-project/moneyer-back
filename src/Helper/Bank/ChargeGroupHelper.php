<?php

namespace App\Helper\Bank;

use App\Entity\Bank\ChargeGroup;
use App\Form\Bank\ChargeGroup\ExpenseGroupType;
use App\Form\Bank\ChargeGroup\IncomeGroupType;

class ChargeGroupHelper
{
    public static function getFormType(ChargeGroup $chargeGroup)
    {
        return match(true) {
            $chargeGroup instanceof ChargeGroup\ExpenseGroup => ExpenseGroupType::class,
            $chargeGroup instanceof ChargeGroup\IncomeGroup => IncomeGroupType::class,
        };
    }
}
