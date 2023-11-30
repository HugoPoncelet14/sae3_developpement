<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use App\Factory\PersonneFactory;
use App\Factory\TypePersonneFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PersonneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        PersonneFactory::createMany(10, function () {
            $nbr_All = AllergeneFactory::faker()->numberBetween(0, 3);
            $list_All = [];
            for ($i = 0; $i < $nbr_All; ++$i) {
                $list_All[] = AllergeneFactory::random();
            }


            return ['typePersonne' => TypePersonneFactory::random(),
                    'allergenes' => $list_All];
        }
        );
    }

    public function getDependencies(): array
    {
        return [TypePersonneFixtures::class, AllergeneFixtures::class];
    }
}
