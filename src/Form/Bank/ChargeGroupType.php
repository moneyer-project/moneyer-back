<?php

namespace App\Form\Bank;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Entity\Bank\ChargeGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChargeGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('amount');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChargeGroup::class,
            'charges_crud' => false,
            'account' => null,
        ]);

        $resolver->setAllowedTypes('charges_crud', 'bool');
        $resolver->setRequired('account');
        $resolver->setAllowedTypes('account', Account::class);
    }

    protected function addChargesField(FormBuilderInterface $builder, array $options, string $entryType): void
    {
        $builder
            ->add('charges', CollectionType::class, [
                'entry_type' => $entryType,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => [
                    'account' => $options['account'],
                    'charge_group' => $builder->getData(),
                ],
                'delete_empty' => function (Charge $charge = null) {
                    return null === $charge || (null === $charge->getName() && null === $charge->getAmount());
                }
            ]);
    }
}
