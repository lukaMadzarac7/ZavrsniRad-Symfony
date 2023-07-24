<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Repository\RatingRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    #[Route('/', name: 'app_admin_base')]
    public function index(ServiceRepository $serviceRepository, UserRepository $userRepository, RatingRepository $ratingRepository): Response
    {
        return $this->render('admin/base/index.html.twig', [
            'controller_name' => 'BaseController',
            'services' => $serviceRepository->findAll(),
            'users' => $userRepository->findAll(),
            'ratings' => $ratingRepository->findAll(),


        ]);

    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard/dashboard.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }


}
