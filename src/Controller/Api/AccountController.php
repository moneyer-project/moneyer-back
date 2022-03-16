<?php

namespace App\Controller\Api;

use App\Entity\Bank\Account;
use App\Entity\User;
use App\Helper\DateTimeHelper;
use App\Repository\Bank\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class AccountController extends AbstractController
{
    #[Route('/api/account', name: 'app_api_account')]
    public function index(Request $request, SerializerInterface $serializer, AccountRepository $accountRepository): Response
    {
        if (!$this->getUser() instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $accounts = new ArrayCollection($accountRepository->findByUser($this->getUser()));

        $account = $accounts->filter(fn (Account $account) => $account->getUser() === $this->getUser())->first();
        $externalAccounts = $accounts->filter(fn (Account $account) => $account->getUser() !== $this->getUser());



        return $this->json($serializer->normalize([
            'account' => $account,
            'externalAccounts' => $externalAccounts,
        ], null, [
            'date' => DateTimeHelper::getByRequest($request),
            AbstractNormalizer::GROUPS => [
                'account:default',
            ],
        ]));
    }
}
