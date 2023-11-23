<?php

namespace App\DataFixtures;

use App\Factory\TypePersonneFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class TypePersonneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/TypePersonne.json";
        $categories = json_decode(file_get_contents($file), true);
        foreach ($categories as $value) {
            TypePersonneFactory::createOne($value);
        }
    }
}
