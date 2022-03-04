<?php

namespace App\Entity\Bank\Charge;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Repository\Bank\Charge\ExpenseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpenseRepository::class)]
class Expense extends Charge
{
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'expenses')]
    #[ORM\JoinColumn(nullable: false)]
    protected $account;

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}
