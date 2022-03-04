<?php

namespace App\Entity\Bank;

use App\Repository\Bank\ChargeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass(repositoryClass: ChargeRepository::class)]
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
}
