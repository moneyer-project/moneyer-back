<?php

namespace App\Form\Bank;

use App\Entity\Bank\PaymentDistribution;
use App\Enum\Bank\DistributionType;
use App\Form\Bank\PaymentDistribution\PayerListType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentDistributionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EnumType::class, [
                'class' => DistributionType::class,
                'required' => false,
            ])
            ->add('payers', PayerListType::class)
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
