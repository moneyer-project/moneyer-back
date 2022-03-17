<?php

namespace App\Entity\Bank;

use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\Charge\Income;
use App\Entity\User;
use App\Repository\Bank\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['account:default', 'transfer:default'])]
    private $id;

    #[ORM\OneToOne(mappedBy: 'account', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[Ignore]
    private $user;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['account:default', 'transfer:default'])]
    private $name;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Income::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Ignore]
    private $incomes;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Expense::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Ignore]
    private $expenses;

    public function __construct()
    {
        $this->incomes = new ArrayCollection();
        $this->expenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        if ($user->getAccount() !== $this) {
            $user->setAccount($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Income>
     */
    public function getIncomes(): Collection
    {
        return $this->incomes;
    }

    public function addIncome(Income $income): self
    {
        if (!$this->incomes->contains($income)) {
            $this->incomes[] = $income;
            $income->setAccount($this);
        }

        return $this;
    }

    public function removeIncome(Income $income): self
    {
        if ($this->incomes->removeElement($income)) {
            // set the owning side to null (unless already changed)
            if ($income->getAccount() === $this) {
                $income->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expense>
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expense $expense): self
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses[] = $expense;
            $expense->setAccount($this);
        }

        return $this;
    }

    public function removeExpense(Expense $expense): self
    {
        if ($this->expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getAccount() === $this) {
                $expense->setAccount(null);
            }
        }

        return $this;
    }
}
