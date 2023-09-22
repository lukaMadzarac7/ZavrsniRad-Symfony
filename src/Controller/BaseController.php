<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Entity\Service;
use App\Entity\ServiceField;
use App\Entity\ServiceImage;
use App\Entity\User;
use App\Entity\UserRating;
use App\Form\EditProfileType;
use App\Form\RatingType;
use App\Form\RegistrationFormType;
use App\Form\ServiceImageType;
use App\Form\ServiceType;
use App\Form\ServiceUserEditType;
use App\Form\UserInformationFormType;
use App\Form\UserInformationType;
use App\Form\UserRatingType;
use App\Form\UserType;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use App\Repository\CountyRepository;
use App\Repository\RatingRepository;
use App\Repository\ServiceFieldRepository;
use App\Repository\ServiceImageRepository;
use App\Repository\ServiceRepository;
use App\Repository\ServiceTypeRepository;
use App\Repository\UserInformationRepository;
use App\Repository\UserRatingRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BaseController extends AbstractController
{

    private Security $security;

    public function __construct(Security $security)
    {

        $this->security = $security;
    }
    #[Route('/', name: 'app_base')]
    public function main(Request $request, ServiceRepository $serviceRepository, ServiceFieldRepository $serviceFieldRepository, CityRepository $cityRepository, CountyRepository $countyRepository): Response
    {
        $user = $this->security->getUser();
        $serviceFields = $serviceFieldRepository->findAll();
        $counties = $countyRepository->findAll();
        $cities = $cityRepository->findAll();

        $searchTerm = $request->query->get('q');
        $selectedField = $request->query->get('field');
        $selectedCity = $request->query->get('city');
        $selectedCounty = $request->query->get('county');

        if ($searchTerm || $selectedField || $selectedCity || $selectedCounty) {
            $field = $serviceFieldRepository->findOneBy(['field' => $selectedField]);
            $county = $countyRepository->findOneBy(['county' => $selectedCounty]);
            $city = $cityRepository->findOneBy(['city' => $selectedCity]);
            $services = $serviceRepository->search($searchTerm, $field, $county, $city);
            shuffle($services);


        } else {
            $services = $serviceRepository->findAll();
            shuffle($services);
        }


        return $this->render('base/main.html.twig', [
            'services' => $services,
            'user' => $user,
            'serviceFields' => $serviceFields,
            'cities' => $cities,
            'counties' => $counties,
            'selectedField' => $selectedField,
            'selectedCity' => $selectedCity,
            'selectedCounty' => $selectedCounty
        ]);
    }

    #[Route('/{id}/profile/', name: 'app_profile', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function user_profile(User $profileUser, UserInformationRepository $informationRepository, RatingRepository $ratingRepository, UserRatingRepository $userRatingRepository): Response
    {
        $user = $this->security->getUser(); // null or UserInterface, if logged in
        //$userId= $user->getUserIdentifier();
        $userInformation = $informationRepository->findOneBy(array('user' => $profileUser));
        $userRatings = $userRatingRepository->findBy(array('user' => $profileUser));
        $averageRating = null;
        if($userRatings != null){
            $sumOfRatings = 0;
            $numberOfRatings = count($userRatings);
            foreach($userRatings as $rating)
            {
                $sumOfRatings = $sumOfRatings + $rating->getRating()->getRatingScore();
            }
            $averageRating = round($sumOfRatings / $numberOfRatings, 1);
        }

        $services = $profileUser->getServices();

        return $this->render('base/profile.html.twig', [
            'user' => $user,
            'profileUser' => $profileUser,
            'userInformation' => $userInformation,
            'services' => $services,
            'ratings' => $userRatings,
            'averageRating' => $averageRating,
        ]);

    }

    #[Route('/service/new', name: 'app_service_user_new', methods: ['GET', 'POST'])]
    public function new_service(ServiceImageRepository $serviceImageRepository, Request $request, ServiceRepository $serviceRepository, CountryRepository $countryRepository): Response
    {
        /** @var UploadedFile $uploadedFile */

        $user = $this->security->getUser(); // null or UserInterface, if logged in
        $service = new Service();
        $currentDate = new \DateTime();
        $service->setDeadline($currentDate);
        $formService = $this->createForm(ServiceUserEditType::class, $service);
        $formService->handleRequest($request);


        if ($formService->isSubmitted() && $formService->isValid()) {

            $service->setOwner($user);
            $service->setUpdater($user);
            $service->setCreator($user);
            $service->setCreatedAt($currentDate);
            $service->setUpdatedAt($currentDate);
            $service->setValidTill($currentDate->modify('+30 day'));

            $service->setCity($formService->get('city')->getData());
            $service->setCounty($service->getCity()->getCounty());
            $country = $countryRepository->findOneBy(array('country' => 'Hrvatska'));
            $service->setCountry($country);

            $serviceRepository->save($service, true);

            $image = $formService["image"]->getData();

            if($image){
                $serviceImage = new ServiceImage();
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$image->guessExtension();
                $serviceImage->setImage($newFilename);
                $serviceImage->setService($service);
                $serviceImage->setCreatedAt(new \DateTime());
                $serviceImage->setUpdatedAt(new \DateTime());
                $serviceImageRepository->save($serviceImage, true);
                $image->move(
                    $destination,
                    $newFilename
                );
            }

            return $this->redirectToRoute('app_profile', [
                'id' => $user->getUserIdentifier(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/base/addService.html.twig', [
            'service' => $service,
            'form' => $formService,
            'user' => $user
        ]);
    }

    #[Route('service/{id}/edit', name: 'app_service_user_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit_service(Request $request, Service $service, ServiceImageRepository $serviceImageRepository, ServiceRepository $serviceRepository, CountryRepository $countryRepository, ServiceTypeRepository $serviceTypeRepository, ServiceFieldRepository $serviceFieldRepository, CityRepository $cityRepository, CountyRepository $countyRepository): Response
    {
        $securityContext = $this->container->get('security.authorization_checker');
        $user = $this->security->getUser(); // null or UserInterface, if logged in
        if($user == $service->getOwner() or $securityContext->isGranted('ROLE_ADMIN') or $securityContext->isGranted('ROLE_EDITOR')){
            $form = $this->createForm(ServiceUserEditType::class, $service);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $service->setUpdater($user);
                $service->setUpdatedAt(new \DateTime());
                $service->setCity($form->get('city')->getData());
                $service->setCounty($service->getCity()->getCounty());
                $country = $countryRepository->findOneBy(array('country' => 'Hrvatska'));
                $service->setCountry($country);

                $serviceRepository->save($service, true);

                $image = $form["image"]->getData();

                if($image){
                    $serviceImage = new ServiceImage();
                    $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$image->guessExtension();
                    $serviceImage->setImage($newFilename);
                    $serviceImage->setService($service);
                    $serviceImage->setCreatedAt(new \DateTime());
                    $serviceImage->setUpdatedAt(new \DateTime());
                    $serviceImageRepository->save($serviceImage, true);
                    $image->move(
                        $destination,
                        $newFilename
                    );
                }

                return $this->redirectToRoute('app_profile', [
                    'id' => $user->getUserIdentifier(),
                ], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('base/editService.html.twig', [
                'service' => $service,
                'form' => $form,
                'user' => $user,
            ]);

        }else{
            $services = $serviceRepository->findAll();
            $selectedCity = null;
            $selectedCounty = null;
            $selectedField = null;
            $serviceFields = $serviceFieldRepository->findAll();
            $counties = $countyRepository->findAll();
            $cities = $cityRepository->findAll();
            
            return $this->render('base/main.html.twig', [
                'services' => $services,
                'user' => $user,
                'serviceFields' => $serviceFields,
                'cities' => $cities,
                'counties' => $counties,
                'selectedField' => $selectedField,
                'selectedCity' => $selectedCity,
                'selectedCounty' => $selectedCounty

            ]);

        }

    }

    #[Route('service/{id}/delete', name: 'app_service_user_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete_service(Request $request, Service $service, ServiceRepository $serviceRepository, ServiceImageRepository $imageRepository): Response
    {
        $securityContext = $this->container->get('security.authorization_checker');
        $user = $this->security->getUser(); // null or UserInterface, if logged in
        $images = $imageRepository->findBy(array('service' => $service));
        if($images!= null){
            $numOfImages = count($images);
            $numOfImages = $numOfImages - 1;
            while($numOfImages>=0){
                $imageRepository->remove($images[$numOfImages]);
                $numOfImages = $numOfImages - 1;
            }
        }

        if($user == $service->getOwner() or $securityContext->isGranted('ROLE_ADMIN')) {
                if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
                    $serviceRepository->remove($service, true);
                }
        }else{
                $services = $serviceRepository->findAll();
                return $this->render('base/main.html.twig', [
                'services' => $services,
                'user' => $user,

                ]);
        }

        return $this->redirectToRoute('app_profile', [
            'id' => $user->getUserIdentifier(),
        ], Response::HTTP_SEE_OTHER);
    }


    #[Route('/profile/edit', name: 'app_profile_user_edit', methods: ['GET', 'POST'])]
    public function edit_profile(Request $request, UserRepository $userRepository, UserInformationRepository $userInformationRepository, CountryRepository $countryRepository): Response
    {
        $user = $this->security->getUser(); // null or UserInterface, if logged in
        $userInformation = $userInformationRepository->findOneBy(array('user' => $user));
        $formUser = $this->createForm(EditProfileType::class, $user);
        $formUserInfo = $this->createForm(UserInformationFormType::class, $userInformation);
        $formUser->handleRequest($request);
        $formUserInfo->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid() && $formUserInfo->isSubmitted() && $formUserInfo->isValid()) {

            $image = $formUser["image"]->getData();

            if($image){
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$image->guessExtension();
                $user->setImage($newFilename);
                $image->move(
                    $destination,
                    $newFilename
                );
            }
            $userInformation->setCity($formUserInfo->get('city')->getData());
            $userInformation->setCounty($userInformation->getCity()->getCounty());
            $country = $countryRepository->findOneBy(array('country' => 'Hrvatska'));
            $userInformation->setCountry($country);
            $password = $formUser["plainPassword"]->getData();
            if ($password != null){
                $hashedPassword = password_hash( $password, PASSWORD_DEFAULT);
                $user->setPassword($hashedPassword);
            }
            $user->setUpdatedAt(new \DateTime());
            $userInformation->setUpdatedAt(new \DateTime());
            $userRepository->save($user, true);
            $userInformationRepository->save($userInformation, true);


            return $this->redirectToRoute('app_profile', ['id' => $user->getUserIdentifier()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('base/editProfile.html.twig', [
            'user' => $user,
            'formUser' => $formUser,
            'formUserInfo' => $formUserInfo,

        ]);
    }

    #[Route('service/{id}/details', name: 'app_service_details', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function service_details(Service $service, UserInformationRepository $informationRepository, ServiceImageRepository $imageRepository): Response
    {
        $user = $this->security->getUser(); // null or UserInterface, if logged in
        $images = $imageRepository->findBy(array('service' => $service));
        $owner = $service->getOwner();
        return $this->render('base/serviceDetails.html.twig', [
            'user' => $user,
            'service' => $service,
            'owner' => $owner,
            'images' => $images,
        ]);

    }



    #[Route('{id}/rate/', name: 'app_rate_user', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    #[IsGranted("ROLE_USER")]
    public function rate_user(Request $request, User $user, RatingRepository $ratingRepository, UserRatingRepository $userRatingRepository, ServiceRepository $serviceRepository): Response
    {
        $rater = $this->security->getUser();

        if($rater != $user){
            $rating = new Rating();
            $userRating = new UserRating();
            $form = $this->createForm(RatingType::class, $rating);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $rating->setRater($rater);
                $rating->setCreatedAt(new \DateTime());
                $rating->setUpdatedAt(new \DateTime());

                $userRating->setUser($user);
                $userRating->setRating($rating);
                $userRating->setCreatedAt(new \DateTime());
                $userRating->setUpdatedAt(new \DateTime());

                $ratingRepository->save($rating, true);
                $userRatingRepository->save($userRating, true);

                return $this->redirectToRoute('app_profile', [
                    'id' => $user->getUserIdentifier(),
                ], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('/base/rateUser.html.twig', [
                'form' => $form,
                'rated' => $user,
                'user' => $rater,
            ]);

        }else{
            $services = $serviceRepository->findAll();
            return $this->render('base/main.html.twig', [
                'services' => $services,
                'user' => $rater,

            ]);

        }
    }
}
