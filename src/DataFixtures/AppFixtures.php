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
use App\Repository\CountyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Role;
use Symfony\Component\Validator\Constraints\Time;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        //Svi statuse usluga//

        ServiceStatusFactory::createOne(['status' => 'Dostupno']);
        ServiceStatusFactory::createOne(['status' => 'Nedostupno']);
        ServiceStatusFactory::createOne(['status' => 'Privremeno nedostupno']);

        //Sve vrste usluga//

        ServiceFieldFactory::createOne(['field' => 'Web development']);
        ServiceFieldFactory::createOne(['field' => 'Android Development']);
        ServiceFieldFactory::createOne(['field' => 'iOS Development']);
        ServiceFieldFactory::createOne(['field' => 'Izrada računalnih programa']);
        ServiceFieldFactory::createOne(['field' => 'Glazbena produkcija']);
        ServiceFieldFactory::createOne(['field' => 'Slikarstvo']);
        ServiceFieldFactory::createOne(['field' => 'Fotografiranje']);
        ServiceFieldFactory::createOne(['field' => 'Pedikura']);
        ServiceFieldFactory::createOne(['field' => 'Manikura']);
        ServiceFieldFactory::createOne(['field' => 'Šminkanje']);
        ServiceFieldFactory::createOne(['field' => 'Organizacija prigoda']);
        ServiceFieldFactory::createOne(['field' => 'Dizajniranje interijera']);
        ServiceFieldFactory::createOne(['field' => 'Živa glazba']);
        ServiceFieldFactory::createOne(['field' => 'Iznajmljivanje vozila']);
        ServiceFieldFactory::createOne(['field' => 'Instrukcije za osnovne škole']);
        ServiceFieldFactory::createOne(['field' => 'Instrukcije za srednje škole']);
        ServiceFieldFactory::createOne(['field' => 'Instrukcije za fakultete']);
        ServiceFieldFactory::createOne(['field' => 'Glazbene instrukcije']);
        ServiceFieldFactory::createOne(['field' => 'Umjetničke instrukcije']);
        ServiceFieldFactory::createOne(['field' => 'Sportske instrukcije']);
        ServiceFieldFactory::createOne(['field' => 'Jezične instrukcije']);
        ServiceFieldFactory::createOne(['field' => 'Ostale instrukcije']);
        ServiceFieldFactory::createOne(['field' => 'Briga o kućnim ljubimcima']);
        ServiceFieldFactory::createOne(['field' => 'Arhitektonske usluge']);
        ServiceFieldFactory::createOne(['field' => 'Majstorske usluge']);
        ServiceFieldFactory::createOne(['field' => 'Usluge dadilje']);
        ServiceFieldFactory::createOne(['field' => 'Usluge šišanja']);
        ServiceFieldFactory::createOne(['field' => 'Servisiranje elektroničkih uređaja']);
        ServiceFieldFactory::createOne(['field' => 'Servisiranje glazbala']);
        ServiceFieldFactory::createOne(['field' => 'Kućanske usluge']);
        ServiceFieldFactory::createOne(['field' => 'Krojačke usluge']);
        ServiceFieldFactory::createOne(['field' => 'Vodoinstalaterstvo']);
        ServiceFieldFactory::createOne(['field' => 'Elektroinstalaterstvo']);
        ServiceFieldFactory::createOne(['field' => 'Keramičke usluge']);
        ServiceFieldFactory::createOne(['field' => 'Stolarske usluge']);
        ServiceFieldFactory::createOne(['field' => 'Soboslikanje']);
        ServiceFieldFactory::createOne(['field' => 'Ostale građevinske usluge']);
        ServiceFieldFactory::createOne(['field' => 'Ostale nekategorizirane usluge']);
        ServiceFieldFactory::createOne(['field' => 'Soboslikanje']);

        //Početni county i country//
        CountyFactory::new()->createOne();
        CountryFactory::new()->createOne();

        //Tipovi usluga//
        ServiceTypeFactory::createOne([
            'type' => 1,
        ]);
        ServiceTypeFactory::createOne([
            'type' => 2,
        ]);

        //Početni gradovi
        CityFactory::createMany(2, function() {
            return [
                'county' => CountyFactory::random(),
            ];

        });

        //Sve uloge//
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

        //Stvaranje nekoliko početnih korisnika//
        UserInformationFactory::createMany(15, function() {
            return [
                'user' => UserFactory::createOne(),
                'city' => CityFactory::random(),
                'county' => CountyFactory::random(),
                'country' => CountryFactory::random(),

            ];

        });

        //Stvaranje početnih usluga//
        ServiceFactory::createMany(50, function() {
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

        //Za random slike usluga//

        //ServiceImageFactory::createMany(20, function() {
        //    return [
        //        'service' => ServiceFactory::random(),
        //        'image' => 'https://picsum.photos/200/300',
        //    ];
        //});

        //Stvaranje ratinga//
        RatingFactory::createMany(60, function() {
            return [
                'rater' => UserFactory::random(),
            ];

        });

        //Stvaranje relacije ratinga//
        UserRatingFactory::createMany(35, function() {
            return [
                'user' => UserFactory::random(),
                'rating' => RatingFactory::random(),

            ];

        });

    }

}
