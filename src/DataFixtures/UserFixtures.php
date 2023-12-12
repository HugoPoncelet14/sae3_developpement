<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/User.json";
        $users = json_decode(file_get_contents($file), true);
        foreach ($users as $value) {
            UserFactory::createOne($value);
        }
    }
}
