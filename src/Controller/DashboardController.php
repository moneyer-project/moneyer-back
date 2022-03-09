<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        if (!$this->getUser() instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('dashboard/index.html.twig', [
            'date' => new \DateTime(),
            'account' => $this->getUser()->getAccount(),
        ]);
    }
}
