<?php

namespace App\DataFixtures;

use App\Factory\QuantiteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class QuantiteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        QuantiteFactory::createMany(20);
    }
}
