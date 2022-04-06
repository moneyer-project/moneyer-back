<?php

namespace App\Entity\Bank\Charge;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Entity\Bank\ChargeGroup\IncomeGroup;
use App\Repository\Bank\ChargeGroup\IncomeGroupRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncomeGroupRepository::class)]
class Income extends Charge
{
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'incomes')]
    #[ORM\JoinColumn(nullable: false)]
    protected $account;

    #[ORM\ManyToOne(targetEntity: IncomeGroup::class, inversedBy: 'charges')]
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

    public function getChargeGroup(): ?IncomeGroup
    {
        return $this->chargeGroup;
    }

    public function setChargeGroup(?IncomeGroup $chargeGroup): self
    {
        $this->chargeGroup = $chargeGroup;

        if (null !== $this->chargeGroup->getAccount()) {
            $this->setAccount($this->chargeGroup->getAccount());
        }

        return $this;
    }
}
