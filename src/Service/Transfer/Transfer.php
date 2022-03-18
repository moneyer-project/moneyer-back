<?php

namespace App\Service\Transfer;

use App\Entity\Bank\Account;
use Symfony\Component\Serializer\Annotation\Groups;

class Transfer
{
    #[Groups(['transfer:default'])]
    private Account $from;

    #[Groups(['transfer:default'])]
    private Account $to;

    #[Groups(['transfer:default'])]
    private int $amount = 0;

    public function __construct(Account $from, Account $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom(): Account
    {
        return $this->from;
    }

    public function getTo(): Account
    {
        return $this->to;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}
