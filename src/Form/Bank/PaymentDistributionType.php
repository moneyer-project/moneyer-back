<?php

namespace App\Form\Bank;

use App\Entity\Bank\PaymentDistribution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentDistributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('payers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PaymentDistribution::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'bank_payment_distribution';
    }
}
