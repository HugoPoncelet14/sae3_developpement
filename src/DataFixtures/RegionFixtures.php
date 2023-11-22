<?php

namespace App\DataFixtures;

use App\Factory\RegionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class RegionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        RegionFactory::createMany(20);
    }
}
