<?php

namespace App\Form\Bank\ChargeGroup;

use App\Entity\Bank\ChargeGroup\ExpenseGroup;
use App\Form\Bank\ChargeGroupType;
use App\Form\Bank\ChargeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseGroupType extends ChargeGroupType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        if ($options['charges_crud']) {
            $builder
                ->add('charges', CollectionType::class, [
                    'entry_type' => ChargeType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExpenseGroup::class,
            'charges_crud' => false,
        ]);

        $resolver->setAllowedTypes('charges_crud', 'bool');
    }
}
