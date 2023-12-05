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
            $typeRecette = null;
            if (isset($infoRecette['nomTpRec'])) {
                $typeRecette = TypeRecetteFactory::random(['nomTpRec' => $infoRecette['nomTpRec']]);
            }

            $pays = null;
            if (isset($infoRecette['nomPays'])) {
                $pays = PaysFactory::random(['nomPays' => $infoRecette['nomPays']]);
            }

            $recette = ['nomRec' => $infoRecette['nomRec'],
                        'tpsDePrep' => $infoRecette['tpsDePrep'],
                        'tpsCuisson' => $infoRecette['tpsCuisson'],
                        'nbrPers' => $infoRecette['nbrPers'],
                        'typeRecette' => $typeRecette,
                        'pays' => $pays];
            RecetteFactory::createOne($recette);
        }
    }

    public function getDependencies(): array
    {
        return [TypeRecetteFixtures::class, PaysFixtures::class];
    }
}
