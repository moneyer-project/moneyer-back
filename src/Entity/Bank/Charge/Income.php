<?php

namespace App\Entity\Bank\Charge;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Repository\Bank\Charge\IncomeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncomeRepository::class)]
class Income extends Charge
{
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'incomes')]
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
