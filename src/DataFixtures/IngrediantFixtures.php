<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use App\Factory\IngrediantFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IngrediantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        IngrediantFactory::createMany(20, function () {
            return ['allergene' => AllergeneFactory::random()];
        });
    }

    public function getDependencies(): array
    {
        return [AllergeneFixtures::class];
    }
}
