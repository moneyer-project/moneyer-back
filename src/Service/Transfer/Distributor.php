<?php

namespace App\Service\Transfer;

use App\Entity\Bank\Charge\Expense;
use App\Enum\Bank\DistributionType;

class Distributor
{
    public function distribute(Pot $pot, Expense $expense)
    {
        if (null !== $expense->getDistribution()) {
            switch ($expense->getDistribution()->getType()) {
                case DistributionType::FiftyFifty:
                    $this->distributeFiftyFifty($pot, $expense);
                    break;
            }
        }
    }

    private function distributeFiftyFifty(Pot $pot, Expense $expense)
    {
        $count = $expense->getDistribution()->getPayers()->count();
        $amount = $expense->getAmount() / $count;

        foreach ($expense->getDistribution()->getPayers() as $payer) {
            $payer === $expense->getAccount()
                ? $pot->set($payer, -$amount)
                : $pot->set($payer, $amount);
        }

        if (!$expense->getDistribution()->getPayers()->contains($expense->getAccount())) {
            $pot->set($expense->getAccount(), -$expense->getAmount());
        }
    }
}
