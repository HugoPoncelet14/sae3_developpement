<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use App\Factory\IngrediantFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IngrediantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Ingrediant.json";
        $ingrediants = json_decode(file_get_contents($file), true);
        foreach ($ingrediants as $infoIngrediant) {

            $allergene = null;
            if (isset($infoIngrediant['nomAll'])) {
                $allergene = AllergeneFactory::random(['nomAll' => $infoIngrediant['nomAll']]);
            }

            $ingrediant = ['nomIng' => $infoIngrediant['nomIng'],
                           'allergene' => $allergene];
            IngrediantFactory::createOne($ingrediant);
        }
    }

    public function getDependencies(): array
    {
        return [AllergeneFixtures::class];
    }
}
