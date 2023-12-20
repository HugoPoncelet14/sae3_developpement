<?php

namespace App\DataFixtures;

use App\Factory\IngrediantFactory;
use App\Factory\QuantiteFactory;
use App\Factory\RecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class QuantiteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {



        $dir = __DIR__;
        $file = "$dir/data/Quantite.json";
        $quantites = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($quantites));
        $progressBar->setFormat('verbose');

        foreach ($quantites as $infoQuantite) {
            $quantite = ['quantite' => $infoQuantite['quantite']];

            if (isset($infoQuantite['unitMesure'])) {
                $quantite['unitMesure'] = $infoQuantite['unitMesure'];
            }

            if (isset($infoQuantite['nomRec'])) {
                $quantite['recette'] = RecetteFactory::random(['nomRec' => $infoQuantite['nomRec']]);
            }

            if (isset($infoQuantite['nomIng'])) {
                $quantite['ingrediant'] = IngrediantFactory::random(['nomIng' => $infoQuantite['nomIng']]);
            }

            QuantiteFactory::createOne($quantite);

            $progressBar->advance();
        }

        $progressBar->finish();
    }

    public function getDependencies(): array
    {
        return [RecetteFixtures::class, IngrediantFixtures::class];
    }
}
