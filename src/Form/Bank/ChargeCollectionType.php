<?php

namespace App\Form\Bank;

use App\Entity\Bank\Charge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChargeCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $prototype = $builder->create('distribution', PaymentDistributionType::class, [
            'mode' => PaymentDistributionType::MODE_ADVANCED
        ]);

        $builder->setAttribute('distribution', $prototype->getForm());
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $distributionForm = $form->getConfig()->getAttribute('distribution');
        $view->vars['distribution'] = $distributionForm->setParent($form)->createView($view);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => function (Charge $charge = null) {
                return null === $charge || (null === $charge->getName() && null === $charge->getAmount());
            }
        ]);
    }

    public function getParent()
    {
        return CollectionType::class;
    }

    public function getBlockPrefix()
    {
        return 'bank_charge_collection';
    }
}
