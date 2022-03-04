<?php

namespace App\Service\Transfer;

use App\Entity\Bank\Account;
use WeakMap;

class Pot
{
    protected WeakMap $paymentMap;

    protected int $total;

    public function __construct()
    {
        $this->paymentMap = new WeakMap();
    }

    public function isEmpty(Account $account): bool
    {
        return $this->paymentMap[$account] === 0;
    }

    public function getMap(): WeakMap
    {
        return $this->paymentMap;
    }

    public function get(Account $account): int
    {
        return $this->paymentMap[$account];
    }

    public function set(Account $account, int $value): void
    {
        if (!isset($this->paymentMap[$account])) {
            $this->paymentMap[$account] = 0;
        }

        $this->paymentMap[$account] += $value;
    }

    public function getNextPositivePayer(): ?Account
    {
        foreach ($this->paymentMap as $account => $amount) {
            if ($amount > 0) {
                return $account;
            }
        }

        return null;
    }

    public function getNextNegativePayer(): ?Account
    {
        foreach ($this->paymentMap as $account => $amount) {
            if ($amount < 0) {
                return $account;
            }
        }

        return null;
    }
}
