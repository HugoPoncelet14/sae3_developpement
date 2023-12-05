<?php

namespace App\DataFixtures;

use App\Factory\PaysFactory;
use App\Factory\RegionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PaysFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Pays.json";
        $infos = json_decode(file_get_contents($file), true);
        foreach ($infos as $infoPays) {
            $pays = ['nomPays' => $infoPays['nomPays']];

            if (isset($infoPays['nomReg'])) {
                $pays['region'] = RegionFactory::random(['nomReg' => $infoPays['nomReg']]);
            }

            PaysFactory::createOne($pays);
        }
    }

    public function getDependencies(): array
    {
        return [RegionFixtures::class];
    }
}
