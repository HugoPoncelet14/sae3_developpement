<?php

namespace App\DataFixtures;

use App\Factory\RecetteFactory;
use App\Factory\TypeRecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class RecetteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        RecetteFactory::createMany(10, function () {
            return ['typeRecette' => TypeRecetteFactory::random()];
        }
        );
    }

    public function getDependencies(): array
    {
        return [TypeRecetteFixtures::class];
    }
}
