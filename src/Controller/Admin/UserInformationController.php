<?php

namespace App\Controller\Admin;

use App\Entity\UserInformation;
use App\Form\UserInformationType;
use App\Repository\UserInformationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/information')]
class UserInformationController extends AbstractController
{
    #[Route('/', name: 'app_user_information_index', methods: ['GET'])]
    public function index(UserInformationRepository $userInformationRepository): Response
    {
        return $this->render('admin/user_information/index.html.twig', [
            'user_informations' => $userInformationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_information_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserInformationRepository $userInformationRepository): Response
    {
        $userInformation = new UserInformation();
        $form = $this->createForm(UserInformationType::class, $userInformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userInformation->setCreatedAt(new \DateTime());
            $userInformation->setUpdatedAt(new \DateTime());

            $userInformationRepository->save($userInformation, true);

            return $this->redirectToRoute('app_user_information_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user_information/new.html.twig', [
            'user_information' => $userInformation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_information_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(UserInformation $userInformation): Response
    {
        return $this->render('admin/user_information/show.html.twig', [
            'user_information' => $userInformation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_information_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, UserInformation $userInformation, UserInformationRepository $userInformationRepository): Response
    {
        $form = $this->createForm(UserInformationType::class, $userInformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userInformation->setUpdatedAt(new \DateTime());
            $userInformationRepository->save($userInformation, true);

            return $this->redirectToRoute('app_user_information_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user_information/edit.html.twig', [
            'user_information' => $userInformation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_information_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, UserInformation $userInformation, UserInformationRepository $userInformationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userInformation->getId(), $request->request->get('_token'))) {
            $userInformationRepository->remove($userInformation, true);
        }

        return $this->redirectToRoute('app_user_information_index', [], Response::HTTP_SEE_OTHER);
    }
}
