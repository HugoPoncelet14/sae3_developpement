<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class AllergeneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Allergene.json";
        $categories = json_decode(file_get_contents($file), true);
        foreach ($categories as $value) {
            AllergeneFactory::createOne($value);
        }
    }
}
