<?php

namespace App\Form\Bank;

use App\Entity\Bank\ChargeGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class ChargeGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('amount');
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['charges_crud']) {
            usort($view['charges']->children, function (FormView $a, FormView $b) {
                $chargeA = $a->vars['data'];
                $chargeB = $b->vars['data'];

                if ($chargeA->getDate() == $chargeB->getDate()) {
                    return 0;
                }

                return ($chargeA->getDate() < $chargeB->getDate()) ? -1 : 1;
            });
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChargeGroup::class,
            'charges_crud' => false,
        ]);

        $resolver->setAllowedTypes('charges_crud', 'bool');
    }
}
