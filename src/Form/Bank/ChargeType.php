<?php

namespace App\Form\Bank;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Entity\Bank\ChargeGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', HiddenType::class, [
                'block_prefix' => 'bank_charge_date',
            ])
            ->add('name', null, [
                'required' => false,
                'block_prefix' => 'bank_charge_name',
            ])
            ->add('amount', null, [
                'required' => false,
                'block_prefix' => 'bank_charge_amount',
            ])
            ->add('distribution', PaymentDistributionType::class, [
                'required' => false,
            ])
        ;

        $builder
            ->get('date')
            ->addViewTransformer(new DateTimeToStringTransformer());

        $builder
            ->addModelTransformer(new CallbackTransformer(function ($value) {
                return $value;
            }, function (Charge $value) use ($options) {
                $value
                    ->setAccount($options['account'])
                    ->setChargeGroup($options['charge_group']);

                return $value;
            }));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Charge::class,
            'account' => null,
            'charge_group' => null,
        ]);

        $resolver->setRequired('account');
        $resolver->setAllowedTypes('account', Account::class);
        $resolver->setAllowedTypes('charge_group', [ChargeGroup::class, 'null']);
    }

    public function getBlockPrefix(): string
    {
        return 'bank_charge';
    }
}
