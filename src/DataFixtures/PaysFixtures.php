<?php

namespace App\DataFixtures;

use App\Factory\PaysFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class PaysFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PaysFactory::createMany(20);
    }
}
