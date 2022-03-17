<?php

namespace App\Controller;

use App\Entity\Bank\Account;
use App\Entity\User;
use App\Helper\DateTimeHelper;
use App\Repository\Bank\AccountRepository;
use App\Service\Transfer\TransferList;
use App\Service\TransferComputer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(Request $request, AccountRepository $accountRepository, TransferComputer $transferComputer): Response
    {
        if (!$this->getUser() instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $date = DateTimeHelper::getByRequest($request);

        $accounts = new ArrayCollection($accountRepository->findByUser($this->getUser()));

        $transfers = $transferComputer->computeForMonth($date, $accounts);

        return $this->render('dashboard/index.html.twig', [
            'date' => $date,
            'account' => $accounts->filter(fn (Account $account) => $account->getUser() === $this->getUser())->first(),
            'externalAccounts' => $accounts->filter(fn (Account $account) => $account->getUser() !== $this->getUser()),
            'transfers' => $transfers,
        ]);
    }
}
