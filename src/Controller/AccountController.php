<?php

namespace App\Controller;

use App\Entity\Bank\Account;
use App\Enum\Voter\AccountType;
use App\Security\Voter\AccountVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account/{account}', name: 'app_account')]
    public function index(Account $account): Response
    {
        $this->denyAccessUnlessGranted(AccountVoter::EDIT, $account);

        return $this->render('account/index.html.twig', [
            'account' => $account,
        ]);
    }
}
