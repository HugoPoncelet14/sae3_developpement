<?php

namespace App\DataFixtures;

use App\Factory\TypeRecetteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class TypeRecetteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/TypeRecette.json";
        $categories = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($categories));
        $progressBar->setFormat('verbose');

        foreach ($categories as $value) {
            TypeRecetteFactory::createOne($value);
            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
