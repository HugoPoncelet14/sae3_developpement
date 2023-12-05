<?php

namespace App\DataFixtures;

use App\Factory\PaysFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class PaysFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Pays.json";
        $pays = json_decode(file_get_contents($file), true);
        foreach ($pays as $values) {
            PaysFactory::createOne($values);
        }
    }
}
