<?php

namespace App\Form\Bank\Charge;

use App\Entity\Bank\Charge\Income;
use App\Form\Bank\ChargeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncomeType extends ChargeType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Income::class,
        ]);
    }
}
