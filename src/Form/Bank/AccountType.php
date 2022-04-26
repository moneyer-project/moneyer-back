<?php

namespace App\Form\Bank;

use App\Entity\Bank\Account;
use App\Form\Bank\ChargeGroup\ExpenseGroupType;
use App\Form\Bank\ChargeGroup\IncomeGroupType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('incomeGroups', CollectionType::class, [
                'entry_type' => IncomeGroupType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => [
                    'account' => $builder->getData(),
                ]
            ])
            ->add('expenseGroups', CollectionType::class, [
                'entry_type' => ExpenseGroupType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => [
                    'account' => $builder->getData(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
