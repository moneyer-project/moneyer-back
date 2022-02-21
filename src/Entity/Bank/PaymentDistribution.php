<?php

namespace App\Entity\Bank;

use App\Repository\Bank\PaymentDistributionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentDistributionRepository::class)]
class PaymentDistribution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Account::class)]
    private $payers;

    public function __construct()
    {
        $this->payers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Account>
     */
    public function getPayers(): Collection
    {
        return $this->payers;
    }

    public function addPayer(Account $payer): self
    {
        if (!$this->payers->contains($payer)) {
            $this->payers[] = $payer;
        }

        return $this;
    }

    public function removePayer(Account $payer): self
    {
        $this->payers->removeElement($payer);

        return $this;
    }
}
