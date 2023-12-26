<?php

namespace App\DataFixtures;

use App\Factory\UstensileFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class UstensilesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Ustensiles.json";
        $ustensiles = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($ustensiles));
        $progressBar->setFormat('verbose');

        foreach ($ustensiles as $infoUstensile) {
            $ustensile = ['name' => $infoUstensile['name']];

            if (isset($infoUstensile['imgUst'])) {
                $ustensile['imgUst'] = file_get_contents("$dir/img/ustensiles/{$infoUstensile['imgUst']}.jpg");
            }
            UstensileFactory::createOne($ustensile);
            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
