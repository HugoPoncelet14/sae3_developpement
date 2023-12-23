<?php

namespace App\DataFixtures;

use App\Factory\EtapeFactory;
use App\Factory\RecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class EtapeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Etape.json";
        $etapes = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($etapes));
        $progressBar->setFormat('verbose');

        foreach ($etapes as $infoEtape) {
            $etape = ['numEtape' => $infoEtape['numEtape'],
                'descEtape' => $infoEtape['descEtape']];

            if (isset($infoEtape['nomRec'])) {
                $etape['recette'] = RecetteFactory::random(['nomRec' => $infoEtape['nomRec']]);
            }

            EtapeFactory::createOne($etape);
            $progressBar->advance();
        }

        $progressBar->finish();
    }

    public function getDependencies(): array
    {
        return [RecetteFixtures::class];
    }
}
