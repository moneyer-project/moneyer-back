<?php

namespace App\Controller;

use App\Entity\Bank\Account;
use App\Form\Bank\AccountType;
use App\Repository\Bank\AccountRepository;
use App\Security\Voter\AccountVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    public function __construct(
        private AccountRepository $accountRepository,
    )
    {
    }

    #[Route('/account/{account}', name: 'app_account')]
    public function index(Request $request, Account $account): Response
    {
        $this->denyAccessUnlessGranted(AccountVoter::EDIT, $account);

        $form = $this->createForm(AccountType::class, $account);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->accountRepository->persist($account);

            $this->addFlash('success', 'Account updated!');

            return $this->redirectToRoute('app_account', [
                'account' => $account->getId()
            ]);
        }

        return $this->render('account/index.html.twig', [
            'account' => $account,
            'form' => $form->createView(),
        ]);
    }
}
