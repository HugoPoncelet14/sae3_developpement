<?php

namespace App\DataFixtures;

use App\Factory\RegionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class RegionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Region.json";
        $regions = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($regions));
        $progressBar->setFormat('verbose');

        foreach ($regions as $region) {
            RegionFactory::createOne($region);
            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
