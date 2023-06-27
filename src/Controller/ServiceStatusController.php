<?php

namespace App\Controller;

use App\Entity\ServiceStatus;
use App\Form\ServiceStatusType;
use App\Repository\ServiceStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/status')]
class ServiceStatusController extends AbstractController
{
    #[Route('/', name: 'app_service_status_index', methods: ['GET'])]
    public function index(ServiceStatusRepository $serviceStatusRepository): Response
    {
        return $this->render('service_status/index.html.twig', [
            'service_statuses' => $serviceStatusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceStatusRepository $serviceStatusRepository): Response
    {
        $serviceStatus = new ServiceStatus();
        $form = $this->createForm(ServiceStatusType::class, $serviceStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceStatusRepository->save($serviceStatus, true);

            return $this->redirectToRoute('app_service_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_status/new.html.twig', [
            'service_status' => $serviceStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_status_show', methods: ['GET'])]
    public function show(ServiceStatus $serviceStatus): Response
    {
        return $this->render('service_status/show.html.twig', [
            'service_status' => $serviceStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceStatus $serviceStatus, ServiceStatusRepository $serviceStatusRepository): Response
    {
        $form = $this->createForm(ServiceStatusType::class, $serviceStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceStatusRepository->save($serviceStatus, true);

            return $this->redirectToRoute('app_service_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_status/edit.html.twig', [
            'service_status' => $serviceStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_status_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceStatus $serviceStatus, ServiceStatusRepository $serviceStatusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceStatus->getId(), $request->request->get('_token'))) {
            $serviceStatusRepository->remove($serviceStatus, true);
        }

        return $this->redirectToRoute('app_service_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
