<?php

namespace App\DataFixtures;

use App\Factory\IngrediantFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class IngrediantFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        IngrediantFactory::createMany(20);
    }
}
