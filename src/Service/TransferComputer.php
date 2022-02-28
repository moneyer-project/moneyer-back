<?php

namespace App\Service;

use App\Entity\Bank\Account;
use App\Service\Transfer\TransferList;

class TransferComputer
{
    public function compute(Account $account): TransferList
    {
        return new TransferList();
    }
}
