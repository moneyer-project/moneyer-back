<?php

namespace App\Controller;

use App\Entity\User;
use App\Helper\DateTimeHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(Request $request): Response
    {
        if (!$this->getUser() instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('dashboard/index.html.twig', [
            'date' => DateTimeHelper::getByRequest($request),
            'account' => $this->getUser()->getAccount(),
        ]);
    }
}
