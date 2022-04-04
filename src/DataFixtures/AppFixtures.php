<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Service;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $service = new Service('RH', 'RH@eit.com');
        $manager->persist($service);
        $manager->flush();

        $service = new Service('COM', 'COM@eit.com');
        $manager->persist($service);
        $manager->flush();

        $service = new Service('Direction', 'Direction@eit.com');
        $manager->persist($service);
        $manager->flush();

        $service = new Service('dev', 'dev@eit.com');
        $manager->persist($service);
        $manager->flush();
    }
}
