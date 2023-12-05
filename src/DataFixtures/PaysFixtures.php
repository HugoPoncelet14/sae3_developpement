<?php

namespace App\DataFixtures;

use App\Factory\PaysFactory;
use App\Factory\RegionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class PaysFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Pays.json";
        $infos = json_decode(file_get_contents($file), true);
        foreach ($infos as $infoPays) {

            $region = null;
            if (isset($infoPays['nomReg'])) {
                $region = RegionFactory::random(['nomReg' => $infoPays['nomReg']]);
            }

            $pays = ['nomPays' => $infoPays['nomPays'],
                     'region' => $region];
            PaysFactory::createOne($pays);
        }
    }

    public function getDependencies(): array
    {
        return [RegionFixtures::class];
    }
}
