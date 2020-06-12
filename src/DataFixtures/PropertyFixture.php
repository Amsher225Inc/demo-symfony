<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr');

        for ($i=0; $i<100; $i++){
            $property = new Property();
            $property
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentence(3, true))
                ->setSurface($faker->numberBetween(3,500))
                ->setRoom($faker->numberBetween(1,10))
                ->setBetroom($faker->numberBetween(1,8))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT)-1))
                ->setFloor($faker->numberBetween(0,15))
                ->setCity($faker->city)
                ->setPrice($faker->numberBetween(100000,5000000))
                ->setAdresse($faker->address)
                ->setPostalCode($faker->postcode)
                ->setCreatedAt(new \DateTime())
                ->setSold(false);
            $manager->persist($property);
        }
        $manager->flush();
    }
}
