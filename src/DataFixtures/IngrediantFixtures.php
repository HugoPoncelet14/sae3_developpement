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
            $ingrediant = ['nomIng' => $infoIngrediant['nomIng']];

            if (isset($infoIngrediant['nomAll'])) {
                $ingrediant['allergene'] = AllergeneFactory::random(['nomAll' => $infoIngrediant['nomAll']]);
            }

            IngrediantFactory::createOne($ingrediant);
        }
    }

    public function getDependencies(): array
    {
        return [AllergeneFixtures::class];
    }
}
