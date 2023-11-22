<?php

namespace App\DataFixtures;

use App\Factory\PersonneFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class PersonneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PersonneFactory::createMany(20);
    }
}
