<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AllergeneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Allergene.json";
        $categories = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($categories));
        $progressBar->setFormat('verbose');

        foreach ($categories as $value) {
            AllergeneFactory::createOne($value);
            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
