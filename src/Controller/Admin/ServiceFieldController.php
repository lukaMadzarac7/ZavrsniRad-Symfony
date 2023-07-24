<?php

namespace App\Controller\Admin;

use App\Entity\ServiceField;
use App\Form\ServiceFieldType;
use App\Repository\ServiceFieldRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/field')]
class ServiceFieldController extends AbstractController
{
    #[Route('/', name: 'app_service_field_index', methods: ['GET'])]
    public function index(ServiceFieldRepository $serviceFieldRepository): Response
    {
        return $this->render('admin/service_field/index.html.twig', [
            'service_fields' => $serviceFieldRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_field_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceFieldRepository $serviceFieldRepository): Response
    {
        $serviceField = new ServiceField();
        $form = $this->createForm(ServiceFieldType::class, $serviceField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceField->setCreatedAt(new \DateTime());
            $serviceField->setUpdatedAt(new \DateTime());

            $serviceFieldRepository->save($serviceField, true);

            return $this->redirectToRoute('app_service_field_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/service_field/new.html.twig', [
            'service_field' => $serviceField,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_field_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(ServiceField $serviceField): Response
    {
        return $this->render('admin/service_field/show.html.twig', [
            'service_field' => $serviceField,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_field_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, ServiceField $serviceField, ServiceFieldRepository $serviceFieldRepository): Response
    {
        $form = $this->createForm(ServiceFieldType::class, $serviceField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceField->setUpdatedAt(new \DateTime());
            $serviceFieldRepository->save($serviceField, true);

            return $this->redirectToRoute('app_service_field_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/service_field/edit.html.twig', [
            'service_field' => $serviceField,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_field_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, ServiceField $serviceField, ServiceFieldRepository $serviceFieldRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceField->getId(), $request->request->get('_token'))) {
            $serviceFieldRepository->remove($serviceField, true);
        }

        return $this->redirectToRoute('app_service_field_index', [], Response::HTTP_SEE_OTHER);
    }
}
