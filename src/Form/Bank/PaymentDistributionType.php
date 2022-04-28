<?php

namespace App\Form\Bank;

use App\Entity\Bank\PaymentDistribution;
use App\Enum\Bank\DistributionType;
use App\Form\Bank\PaymentDistribution\PayerListType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentDistributionType extends AbstractType
{
    const MODE_SIMPLE = 'simple';

    const MODE_ADVANCED = 'advanced';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EnumType::class, [
                'class' => DistributionType::class,
                'required' => false,
            ])
            ->add('payers', PayerListType::class);

        if ($options['mode'] === self::MODE_ADVANCED) {
            $builder
                ->add('search', SearchType::class, [
                    'mapped' => false,
                    'required' => false,
                ])
                ->add('date_debut', DateType::class, [
                    'mapped' => false,
                    'required' => false,
                    'widget' => 'single_text',
                ])
                ->add('date_fin', DateType::class, [
                    'mapped' => false,
                    'required' => false,
                    'widget' => 'single_text',
                ]);
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['mode'] = $options['mode'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PaymentDistribution::class,
            'mode' => self::MODE_SIMPLE,
        ]);

        $resolver->setAllowedValues('mode', [self::MODE_SIMPLE, self::MODE_ADVANCED]);
    }

    public function getBlockPrefix()
    {
        return 'bank_payment_distribution';
    }
}
