<?php

namespace App\DataFixtures;

use App\Controller\ServiceController;
use App\Entity\City;
use App\Entity\Rating;
use App\Entity\ServiceStatus;
use App\Factory\CityFactory;
use App\Factory\CountryFactory;
use App\Factory\CountyFactory;
use App\Factory\QuestionFactory;
use App\Factory\RatingFactory;
use App\Factory\ServiceFactory;
use App\Factory\ServiceFieldFactory;
use App\Factory\ServiceImageFactory;
use App\Factory\ServiceStatusFactory;
use App\Factory\ServiceTypeFactory;
use App\Factory\UserFactory;
use App\Factory\UserInformationFactory;
use App\Factory\UserRatingFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Validator\Constraints\Time;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        //Redovni podaci//

        ServiceStatusFactory::new()->createMany(5);
        ServiceFieldFactory::new()->createMany(5);
        CountyFactory::new()->createMany(5);
        CountryFactory::new()->createMany(5);

        ServiceTypeFactory::createOne([
            'type' => 1,
        ]);
        ServiceTypeFactory::createOne([
            'type' => 2,
        ]);


        CityFactory::createMany(5, function() {
            return [
                'county' => CountyFactory::random(),
            ];

        });


        $role1 = new Role();
        $role1->setRole("ROLE_ADMIN");
        $role2 = new Role();
        $role2->setRole("ROLE_USER");
        $role3 = new Role();
        $role3->setRole("ROLE_EDITOR");
        $role4 = new Role();
        $role4->setRole("ROLE_ALLOWED_TO_SWITCH");

        $manager->persist($role1);
        $manager->persist($role2);
        $manager->persist($role3);
        $manager->persist($role4);

        $manager->flush();

        //---//

        //UserFactory::new()->createMany(25);

        UserInformationFactory::createMany(35, function() {
            return [
                'user' => UserFactory::createOne(),
                'city' => CityFactory::random(),
                'county' => CountyFactory::random(),
                'country' => CountryFactory::random(),

            ];

        });

        #ako se ukljuce ove linije nece se izgenerirati nista iz ovog file-a, kad se maknu sve normalno radi
        #takoder javlja error da ne postoji creator_at u serviceu kad zelis novi service izraditi
        #sve migracije runnane
        ServiceFactory::createMany(35, function() {
            return [
                'owner' => UserFactory::random(),
                'creator' => UserFactory::random(),
                'updater' => UserFactory::random(),
                'service_status' => ServiceStatusFactory::random(),
                'service_type' => ServiceTypeFactory::random(),
                'service_field' => ServiceFieldFactory::random(),
                'city' => CityFactory::random(),
                'county' => CountyFactory::random(),
                'country' => CountryFactory::random(),

            ];

        });


        ServiceImageFactory::createMany(20, function() {
            return [
                'service' => ServiceFactory::random(),
                'image' => 'https://picsum.photos/200/300',
            ];

        });



        /* Faker ne kuzi kako raditi OneToOne objekte
        ServiceImageFactory::createMany(20, function() {
            return [
                'service' => ServiceFactory::random(),
            ];

        });
        */


        RatingFactory::createMany(35, function() {
            return [
                'rater' => UserFactory::random(),
            ];

        });

        UserRatingFactory::createMany(35, function() {
            return [
                'user' => UserFactory::random(),
                'rating' => RatingFactory::random(),

            ];

        });



    }
}
