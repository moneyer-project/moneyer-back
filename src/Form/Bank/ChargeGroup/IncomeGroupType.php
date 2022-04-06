<?php

namespace App\Form\Bank\ChargeGroup;

use App\Entity\Bank\ChargeGroup\IncomeGroup;
use App\Form\Bank\Charge\IncomeType;
use App\Form\Bank\ChargeGroupType;
use App\Form\Bank\ChargeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncomeGroupType extends ChargeGroupType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        if ($options['charges_crud']) {
            $builder
                ->add('charges', CollectionType::class, [
                    'entry_type' => IncomeType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => IncomeGroup::class,
            'charges_crud' => false,
        ]);

        $resolver->setAllowedTypes('charges_crud', 'bool');
    }
}
