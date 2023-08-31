<?php

namespace App\Controller;

use App\Entity\ServiceImage;
use App\Entity\User;
use App\Entity\UserInformation;
use App\Form\RegistrationFormType;
use App\Form\UserInformationFormType;
use App\Repository\CountryRepository;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager, CountryRepository $countryRepository): Response
    {
        $user = new User();
        $userInformation = new UserInformation();
        $formUser = $this->createForm(RegistrationFormType::class, $user);
        $formUserInfo = $this->createForm(UserInformationFormType::class, $userInformation);
        $formUser->handleRequest($request);
        $formUserInfo->handleRequest($request);


        if ($formUser->isSubmitted() && $formUser->isValid() && $formUserInfo->isSubmitted() && $formUserInfo->isValid()) {
            // encode the plain password
            $user->setRole(4);
            $userInformation->setCity($formUserInfo->get('city')->getData());
            $userInformation->setCounty($userInformation->getCity()->getCounty());
            $country = $countryRepository->findOneBy(array('country' => 'Hrvatska'));
            $userInformation->setCountry($country);
            $user->setCreatedAt(new \DateTime());
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $formUser->get('plainPassword')->getData()
                )
            );

            $userInformation->setUser($user);
            $userInformation->setCreatedAt(new \DateTime());

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

            $entityManager->persist($user);
            $entityManager->persist($userInformation);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $formUser->createView(),
            'userInformationForm' => $formUserInfo->createView(),

        ]);
    }
}
