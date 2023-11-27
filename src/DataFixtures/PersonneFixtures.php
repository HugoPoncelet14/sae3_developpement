<?php

namespace App\DataFixtures;

use App\Factory\PersonneFactory;
use App\Factory\TypePersonneFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class PersonneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        PersonneFactory::createMany(10, function () {
            $rep = ['typePersonne' => null];
            if (PersonneFactory::faker()->boolean(90)) {
                $rep = ['typePersonne' => TypePersonneFactory::random()];
            }

            return $rep;
        }
        );
    }

    public function getDependencies(): array
    {
        return [TypePersonneFixtures::class];
    }
}
