<?php

namespace App\DataFixtures;

use App\Controller\ServiceController;
use App\Factory\RatingFactory;
use App\Factory\ServiceFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Validator\Constraints\Time;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        UserFactory::new()->createMany(20);
        ServiceFactory::new()->createMany(20);
        RatingFactory::new()->createMany(20);

        $role1 = new Role();
        $role1->setRole("ROLE_ADMIN");
        $role2 = new Role();
        $role2->setRole("ROLE_USER");
        $role3 = new Role();
        $role3->setRole("ROLE_EDITOR");

        $manager->persist($role1);
        $manager->persist($role2);
        $manager->persist($role3);
        $manager->flush();

    }
}
