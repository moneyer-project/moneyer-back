<?php

namespace App\Service\Transfer;

use App\Entity\Bank\Account;

class PotRepartitor
{
    public function repartition(Pot $pot, TransferList $transfers): void
    {
        foreach ($pot->getMap() as $account => $amount) {

            while ($pot->get($account) !== 0) {
                $transfer = $pot->get($account) > 0
                    ? $this->createTransfer($pot, $account, $pot->getNextNegativePayer())
                    : $this->createTransfer($pot, $pot->getNextPositivePayer(), $account);

                $transfers->add($transfer);
            }
        }
    }

    private function createTransfer(Pot $pot, Account $payer, Account $receiver): Transfer
    {
        $transfer = new Transfer($payer, $receiver);

        $amountPayer = abs($pot->get($payer));
        $amountReceiver = abs($pot->get($receiver));

        $amount = min($amountPayer, $amountReceiver);

        $transfer->setAmount($amount);

        $pot->set($payer, -$amount);
        $pot->set($receiver, $amount);

        return $transfer;
    }
}
