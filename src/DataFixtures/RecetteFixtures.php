<?php

namespace App\DataFixtures;

use App\Factory\PaysFactory;
use App\Factory\RecetteFactory;
use App\Factory\TypeRecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecetteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Recette.json";
        $recettes = json_decode(file_get_contents($file), true);

        foreach ($recettes as $infoRecette) {
            $recette = ['nomRec' => $infoRecette['nomRec'],
                'tpsDePrep' => $infoRecette['tpsDePrep'],
                'nbrPers' => $infoRecette['nbrPers'],
            ];
            if (isset($infoRecette['tpsCuisson'])) {
                $recette['tpsCuisson'] = $infoRecette['tpsCuisson'];
            }

            if (isset($infoRecette['nomTpRec'])) {
                $recette['typeRecette'] = TypeRecetteFactory::random(['nomTpRec' => $infoRecette['nomTpRec']]);
            }

            if (isset($infoRecette['nomPays'])) {
                $recette['pays'] = PaysFactory::random(['nomPays' => $infoRecette['nomPays']]);
            }

            if (isset($infoRecette['imgRec'])) {
                $recette['imgRec'] = file_get_contents("$dir/img/recettes/{$infoRecette['imgRec']}.jpg");
            }

            RecetteFactory::createOne($recette);
        }
    }

    public function getDependencies(): array
    {
        return [TypeRecetteFixtures::class, PaysFixtures::class];
    }
}
