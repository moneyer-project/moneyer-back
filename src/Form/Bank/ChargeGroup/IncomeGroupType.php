<?php

namespace App\Form\Bank\ChargeGroup;

use App\Entity\Bank\ChargeGroup\IncomeGroup;
use App\Form\Bank\Charge\IncomeType;
use App\Form\Bank\ChargeGroupType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncomeGroupType extends ChargeGroupType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        if ($options['charges_crud']) {
            $this->addChargesField($builder, $options, IncomeType::class);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => IncomeGroup::class,
        ]);
    }
}
