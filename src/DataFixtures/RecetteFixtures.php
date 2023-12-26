<?php

namespace App\DataFixtures;

use App\Factory\PaysFactory;
use App\Factory\RecetteFactory;
use App\Factory\TypeRecetteFactory;
use App\Factory\UstensileFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class RecetteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Recette.json";
        $recettes = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($recettes));
        $progressBar->setFormat('verbose');

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

            if (isset($infoRecette['ustensiles'])) {
                $ustensiles = $infoRecette['ustensiles'];
                $list = [];
                foreach ($ustensiles as $ustensile) {
                    $list[] = UstensileFactory::random(['name' => $ustensile]);
                }
                $recette['ustensiles'] = $list;
            }
            RecetteFactory::createOne($recette);
            $progressBar->advance();
        }
        $progressBar->finish();
    }

    public function getDependencies(): array
    {
        return [TypeRecetteFixtures::class, PaysFixtures::class, UstensilesFixtures::class];
    }
}
