<?php

namespace App\Controller;

use App\Entity\Bank\ChargeGroup;
use App\Helper\Bank\ChargeGroupHelper;
use App\Repository\Bank\ChargeGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChargeGroupController extends AbstractController
{
    public function __construct(
        private ChargeGroupRepository $chargeGroupRepository,
    )
    {
    }

    #[Route('/account/charge-group/{chargeGroup}', name: 'app_account_charge_group')]
    public function index(Request $request, ChargeGroup $chargeGroup): Response
    {
        $form = $this->createForm(ChargeGroupHelper::getFormType($chargeGroup), $chargeGroup, [
            'action' => $this->generateUrl('app_account_charge_group', ['chargeGroup' => $chargeGroup->getId()]),
            'account' => $chargeGroup->getAccount(),
            'charges_crud' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->chargeGroupRepository->persist($chargeGroup);

            $this->addFlash('success', 'Charge group updated!');

            return $this->redirectToRoute('app_account', [
                'account' => $chargeGroup->getAccount()->getId()
            ]);
        }

        return $this->render('charge-group/index.html.twig', [
            'account' => $chargeGroup->getAccount(),
            'chargeGroup' => $chargeGroup,
            'form' => $form->createView(),
        ]);
    }
}
