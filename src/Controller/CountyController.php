<?php

namespace App\Controller;

use App\Entity\County;
use App\Form\CountyType;
use App\Repository\CountyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/county')]
class CountyController extends AbstractController
{
    #[Route('/', name: 'app_county_index', methods: ['GET'])]
    public function index(CountyRepository $countyRepository): Response
    {
        return $this->render('county/index.html.twig', [
            'counties' => $countyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_county_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CountyRepository $countyRepository): Response
    {
        $county = new County();
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $countyRepository->save($county, true);

            return $this->redirectToRoute('app_county_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('county/new.html.twig', [
            'county' => $county,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_county_show', methods: ['GET'])]
    public function show(County $county): Response
    {
        return $this->render('county/show.html.twig', [
            'county' => $county,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_county_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, County $county, CountyRepository $countyRepository): Response
    {
        $form = $this->createForm(CountyType::class, $county);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $countyRepository->save($county, true);

            return $this->redirectToRoute('app_county_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('county/edit.html.twig', [
            'county' => $county,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_county_delete', methods: ['POST'])]
    public function delete(Request $request, County $county, CountyRepository $countyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$county->getId(), $request->request->get('_token'))) {
            $countyRepository->remove($county, true);
        }

        return $this->redirectToRoute('app_county_index', [], Response::HTTP_SEE_OTHER);
    }
}
