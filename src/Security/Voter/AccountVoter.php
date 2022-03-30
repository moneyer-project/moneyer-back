<?php

namespace App\Security\Voter;

use App\Entity\Bank\Account;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AccountVoter extends Voter
{
    public const EDIT = 'ACCOUNT_EDIT';

    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Account && in_array($attribute, [
                self::EDIT
            ]);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if (!$subject instanceof Account) {
            return false;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        return match ($attribute) {
            self::EDIT => $user === $subject->getUser(),
        };
    }
}
