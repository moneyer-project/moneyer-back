<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Helper\DateTimeHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class AccountController extends AbstractController
{
    #[Route('/api/account', name: 'app_api_account')]
    public function index(Request $request, SerializerInterface $serializer): Response
    {
        if (!$this->getUser() instanceof User) {
            throw $this->createAccessDeniedException();
        }

        return $this->json([
            'account' => $serializer->normalize($this->getUser()->getAccount(), null, [
                'date' => DateTimeHelper::getByRequest($request),
                AbstractNormalizer::ATTRIBUTES => [
                    'name',
                ],
            ])
        ]);
    }
}
