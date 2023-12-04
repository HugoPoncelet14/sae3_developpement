<?php

namespace App\DataFixtures;

use App\Factory\RegionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Region.json";
        $regions = json_decode(file_get_contents($file), true);
        foreach ($regions as $region) {
            RegionFactory::createOne($region);
        }
    }
}
