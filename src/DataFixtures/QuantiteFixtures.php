<?php

namespace App\DataFixtures;

use App\Factory\IngrediantFactory;
use App\Factory\QuantiteFactory;
use App\Factory\RecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuantiteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        QuantiteFactory::createMany(20, function () {
            return ['recette' => RecetteFactory::random(),
                    'ingrediant' => IngrediantFactory::random()];
        });
    }

    public function getDependencies(): array
    {
        return [RecetteFixtures::class, IngrediantFixtures::class];
    }
}
