<?php

namespace App\Form\Bank\Charge;

use App\Entity\Bank\Charge\Expense;
use App\Form\Bank\ChargeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseType extends ChargeType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expense::class,
        ]);
    }
}
