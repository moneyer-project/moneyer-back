<?php

namespace App\Entity\Bank;

use App\Entity\Bank\Charge\Expense;
use App\Entity\Bank\Charge\Income;
use App\Entity\Bank\ChargeGroup\ExpenseGroup;
use App\Repository\Bank\ChargeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChargeRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "income" => Income::class,
    "expense" => Expense::class,
])]
abstract class Charge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 100)]
    protected $name;

    #[ORM\Column(type: 'integer')]
    protected $amount;

    #[ORM\Column(type: 'date')]
    protected $date;

    #[ORM\OneToOne(targetEntity: PaymentDistribution::class, cascade: ['persist', 'remove'])]
    private $distribution;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDistribution(): ?PaymentDistribution
    {
        return $this->distribution;
    }

    public function setDistribution(?PaymentDistribution $distribution): self
    {
        $this->distribution = $distribution;

        return $this;
    }

    public abstract function getAccount(): ?Account;

    public abstract function getChargeGroup(): ?ChargeGroup;
}
