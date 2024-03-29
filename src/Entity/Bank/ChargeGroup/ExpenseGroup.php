<?php

namespace App\Entity\Bank\ChargeGroup;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\ChargeGroup;
use App\Repository\Bank\ChargeGroup\ExpenseGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpenseGroupRepository::class)]
class ExpenseGroup extends ChargeGroup
{
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'expenseGroups')]
    #[ORM\JoinColumn(nullable: false)]
    protected $account;

    #[ORM\OneToMany(mappedBy: 'chargeGroup', targetEntity: Expense::class, cascade: ['persist'], orphanRemoval: true)]
    #[Assert\Valid]
    private $charges;

    public function __construct()
    {
        $this->charges = new ArrayCollection();
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection<int, Charge>
     */
    public function getCharges(): Collection
    {
        return $this->charges;
    }

    public function addCharge(Charge $charge): self
    {
        if (!$this->charges->contains($charge)) {
            $this->charges[] = $charge;
            $charge->setChargeGroup($this);
        }

        return $this;
    }

    public function removeCharge(Charge $charge): self
    {
        if ($this->charges->removeElement($charge)) {
            // set the owning side to null (unless already changed)
            if ($charge->getChargeGroup() === $this) {
                $charge->setChargeGroup(null);
            }
        }

        return $this;
    }
}
