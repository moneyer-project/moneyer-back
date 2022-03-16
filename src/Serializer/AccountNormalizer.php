<?php

namespace App\Serializer;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Entity\Bank\Charge\Income;
use App\Repository\Bank\Charge\ExpenseRepository;
use App\Repository\Bank\Charge\IncomeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Exception\LogicException;

class AccountNormalizer implements ContextAwareNormalizerInterface
{
    public function __construct(
        private ObjectNormalizer  $normalizer,
        private IncomeRepository  $incomeRepository,
        private ExpenseRepository $expenseRepository,
    )
    {
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Account;
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        if (!$object instanceof Account) {
            throw new LogicException('The AccountNormalizer can only normalize Account objects.');
        }

        $data = $this->normalizer->normalize($object, $format, $context);

        if (isset($context['date'])) {
            $incomes = $this->incomeRepository->findInMonth($object, $context['date']);
            $expenses = $this->expenseRepository->findInMonth($object, $context['date']);

            $data['income'] = array_reduce($incomes, fn($accumulator, Charge $charge) => $accumulator + $charge->getAmount());
            $data['expense'] = array_reduce($expenses, fn($accumulator, Charge $charge) => $accumulator + $charge->getAmount());
            $data['balance'] = $data['income'] - $data['expense'];
        }

        return $data;
    }
}
