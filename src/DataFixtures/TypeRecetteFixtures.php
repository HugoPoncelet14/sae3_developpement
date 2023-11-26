<?php

namespace App\DataFixtures;

use App\Factory\TypeRecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class TypeRecetteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/TypeRecette.json";
        $categories = json_decode(file_get_contents($file), true);
        foreach ($categories as $value) {
            TypeRecetteFactory::createOne($value);
        }
    }
}
