<?php

namespace App\Form\Bank\PaymentDistribution;

use App\Entity\Bank\Account;
use App\Repository\Bank\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class PayerListType extends AbstractType implements DataTransformerInterface
{
    public function __construct(
        private AccountRepository $accountRepository
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addViewTransformer($this);
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
