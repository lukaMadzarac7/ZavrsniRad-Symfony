<?php

namespace App\Controller;

use App\Entity\ServiceType;
use App\Form\ServiceTypeType;
use App\Repository\ServiceTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/type')]
class ServiceTypeController extends AbstractController
{
    #[Route('/', name: 'app_service_type_index', methods: ['GET'])]
    public function index(ServiceTypeRepository $serviceTypeRepository): Response
    {
        return $this->render('service_type/index.html.twig', [
            'service_types' => $serviceTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceTypeRepository $serviceTypeRepository): Response
    {
        $serviceType = new ServiceType();
        $form = $this->createForm(ServiceTypeType::class, $serviceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceTypeRepository->save($serviceType, true);

            return $this->redirectToRoute('app_service_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_type/new.html.twig', [
            'service_type' => $serviceType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_type_show', methods: ['GET'])]
    public function show(ServiceType $serviceType): Response
    {
        return $this->render('service_type/show.html.twig', [
            'service_type' => $serviceType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceType $serviceType, ServiceTypeRepository $serviceTypeRepository): Response
    {
        $form = $this->createForm(ServiceTypeType::class, $serviceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceTypeRepository->save($serviceType, true);

            return $this->redirectToRoute('app_service_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_type/edit.html.twig', [
            'service_type' => $serviceType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_type_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceType $serviceType, ServiceTypeRepository $serviceTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceType->getId(), $request->request->get('_token'))) {
            $serviceTypeRepository->remove($serviceType, true);
        }

        return $this->redirectToRoute('app_service_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
