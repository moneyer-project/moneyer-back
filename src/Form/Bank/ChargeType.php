<?php

namespace App\Form\Bank;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use App\Entity\Bank\ChargeGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('checkbox', CheckboxType::class, [
                'label' => false,
                'mapped' => false,
            ])
            ->add('date', HiddenType::class)
            ->add('name', null, [
                'required' => false,
            ])
            ->add('amount', null, [
                'required' => false,
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
}
