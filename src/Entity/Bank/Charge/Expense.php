<?php

namespace App\Entity\Bank\Charge;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Entity\Bank\ChargeGroup\ExpenseGroup;
use App\Repository\Bank\ChargeGroup\ExpenseGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpenseGroupRepository::class)]
class Expense extends Charge
{
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'expenses')]
    #[ORM\JoinColumn(nullable: false)]
    protected $account;

    #[ORM\ManyToOne(targetEntity: ExpenseGroup::class, inversedBy: 'charges')]
    private $chargeGroup;

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getChargeGroup(): ?ExpenseGroup
    {
        return $this->chargeGroup;
    }

    public function setChargeGroup(?ExpenseGroup $chargeGroup): self
    {
        $this->chargeGroup = $chargeGroup;

        return $this;
    }
}
