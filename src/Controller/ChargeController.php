<?php

namespace App\Controller;

use App\Entity\Bank\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChargeController extends AbstractController
{
    #[Route('/account/{account}/charges', name: 'app_account_charges')]
    public function index(Account $account): Response
    {
        return $this->render('charge/index.html.twig', [
            'controller_name' => 'ChargeController',
            'account' => $account,
        ]);
    }
}
