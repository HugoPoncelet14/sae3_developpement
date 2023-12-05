<?php

namespace App\DataFixtures;

use App\Factory\EtapeFactory;
use App\Factory\RecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EtapeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Etape.json";
        $etapes = json_decode(file_get_contents($file), true);
        foreach ($etapes as $infoEtape) {
            $etape = ['numEtape' => $infoEtape['numEtape'],
                'descEtape' => $infoEtape['descEtape']];

            if (isset($infoEtape['nomRec'])) {
                $etape['recette'] = RecetteFactory::random(['nomRec' => $infoEtape['nomRec']]);
            }

            EtapeFactory::createOne($etape);
        }
    }

    public function getDependencies(): array
    {
        return [RecetteFixtures::class];
    }
}
