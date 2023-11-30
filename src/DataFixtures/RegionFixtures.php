<?php

namespace App\DataFixtures;

use App\Factory\PaysFactory;
use App\Factory\RegionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        RegionFactory::createMany(20, function () {
            return ['pays' => PaysFactory::random()];
        });
    }

    public function getDependencies(): array
    {
        return [PaysFixtures::class];
    }
}
