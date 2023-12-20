<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/User.json";
        $users = json_decode(file_get_contents($file), true);
        foreach ($users as $value) {
            $nbr_All = AllergeneFactory::faker()->numberBetween(0, 3);
            $list_All = [];
            for ($i = 0; $i < $nbr_All; ++$i) {
                $list_All[] = AllergeneFactory::random();
            }
            $value['allergenes'] = $list_All;
            UserFactory::createOne($value);
        }

        UserFactory::createMany(8, function () {
            $nbr_All = AllergeneFactory::faker()->numberBetween(0, 3);
            $list_All = [];
            for ($i = 0; $i < $nbr_All; ++$i) {
                $list_All[] = AllergeneFactory::random();
            }

            return ['allergenes' => $list_All];
        });
    }
}
