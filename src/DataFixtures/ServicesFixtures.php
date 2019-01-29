<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ServicesData;


class ServicesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);

//=========================Services fake=====

        for($i=0;$i!=3;$i++){

            $services = new ServicesData();
            $services->setnameService($faker->jobTitle())
                     ->setMailRef($faker->email())
                     ->setMailSecondary($faker->email());

            $manager->persist($services);
        }

        $manager->flush();
    }
}
