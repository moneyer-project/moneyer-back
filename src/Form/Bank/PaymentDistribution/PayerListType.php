<?php

namespace App\Form\Bank\PaymentDistribution;

use App\Entity\Bank\Account;
use App\Repository\Bank\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayerListType extends AbstractType implements DataTransformerInterface
{
    public function __construct(
        private AccountRepository $accountRepository
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['allow_search']) {
            $search = $builder->create('search', SearchType::class, [
                'required' => false,
                'attr' => [
                    'data-payer-list-target' => 'search',
                    'placeholder' => 'Search',
                ],
            ]);
            $builder->setAttribute('search', $search->getForm());
        }

        $builder
            ->addViewTransformer($this);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['allow_search'] = $options['allow_search'];

        if ($options['allow_search']) {
            $search = $form->getConfig()->getAttribute('search');
            $view->vars['search'] = $search->setParent($form)->createView($view);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_search' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
        ]);

        $resolver->setAllowedTypes('allow_search', 'bool');
    }

    public function getParent()
    {
        return CollectionType::class;
    }

    public function transform(mixed $value)
    {
        if (null !== $value) {
            $emails = new ArrayCollection();

            foreach ($value as $account) {
                if ($account instanceof Account) {
                    $emails->add($account->getUser()?->getEmail());
                }
            }

            return $emails;
        }

        return $value;
    }

    public function reverseTransform(mixed $value)
    {
        $accounts = new ArrayCollection();

        foreach ($value as $email) {
            if (!empty($email)) {
                $account = $this->accountRepository->findOneByEmail($email);
                $accounts->add($account);
            }
        }

        return $accounts;
    }
}
