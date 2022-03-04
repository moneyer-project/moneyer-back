<?php

namespace App\Service;

use App\Entity\Bank\Account;
use App\Service\Transfer\Distributor;
use App\Service\Transfer\Pot;
use App\Service\Transfer\PotRepartitor;
use App\Service\Transfer\TransferList;

class TransferComputer
{
    public function __construct(
        private Distributor $distributor,
        private PotRepartitor $potRepartitor,
    )
    {
    }

    public function computeForMonth(\DateTime $date, array $accounts): TransferList
    {
        $transfers = new TransferList();

        $pot = $this->createPot($date, $accounts);

        $this->potRepartitor->repartition($pot, $transfers);

        return $transfers;
    }

    private function createPot(\DateTime $date, array $accounts): Pot
    {
        $pot = new Pot();

        /** @var Account $account */
        foreach ($accounts as $account) {
            foreach ($account->getExpenses() as $expense) {
                if ($expense->getDate()->format('Y-m') === $date->format('Y-m')) {
                    $this->distributor->distribute($pot, $expense);
                }
            }
        }

        return $pot;
    }
}
