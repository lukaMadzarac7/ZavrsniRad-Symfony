<?php

namespace App\Controller;

use App\Entity\ServiceImage;
use App\Form\ServiceImageType;
use App\Repository\ServiceImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/image')]
class ServiceImageController extends AbstractController
{
    #[Route('/', name: 'app_service_image_index', methods: ['GET'])]
    public function index(ServiceImageRepository $serviceImageRepository): Response
    {
        return $this->render('service_image/index.html.twig', [
            'service_images' => $serviceImageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_image_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceImageRepository $serviceImageRepository): Response
    {
        $serviceImage = new ServiceImage();
        $form = $this->createForm(ServiceImageType::class, $serviceImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceImageRepository->save($serviceImage, true);

            return $this->redirectToRoute('app_service_image_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_image/new.html.twig', [
            'service_image' => $serviceImage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_image_show', methods: ['GET'])]
    public function show(ServiceImage $serviceImage): Response
    {
        return $this->render('service_image/show.html.twig', [
            'service_image' => $serviceImage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_image_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceImage $serviceImage, ServiceImageRepository $serviceImageRepository): Response
    {
        $form = $this->createForm(ServiceImageType::class, $serviceImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceImageRepository->save($serviceImage, true);

            return $this->redirectToRoute('app_service_image_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_image/edit.html.twig', [
            'service_image' => $serviceImage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_image_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceImage $serviceImage, ServiceImageRepository $serviceImageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceImage->getId(), $request->request->get('_token'))) {
            $serviceImageRepository->remove($serviceImage, true);
        }

        return $this->redirectToRoute('app_service_image_index', [], Response::HTTP_SEE_OTHER);
    }
}
