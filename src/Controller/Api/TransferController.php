<?php

namespace App\Controller\Api;

use App\Entity\Bank\Account;
use App\Entity\User;
use App\Helper\DateTimeHelper;
use App\Repository\Bank\AccountRepository;
use App\Service\TransferComputer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class TransferController extends AbstractController
{
    #[Route('/api/transfers', name: 'app_api_transfers')]
    public function index(Request $request, SerializerInterface $serializer, AccountRepository $accountRepository, TransferComputer $transferComputer): Response
    {
        if (!$this->getUser() instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $accounts = new ArrayCollection($accountRepository->findByUser($this->getUser()));

        $transfers = $transferComputer->computeForMonth(DateTimeHelper::getByRequest($request), $accounts);

        return $this->json($serializer->normalize([
            'transfers' => $transfers
        ], null, [
            AbstractNormalizer::GROUPS => [
                'transfer:default',
            ],
        ]));
    }
}
