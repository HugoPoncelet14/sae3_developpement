<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use App\Factory\IngrediantFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class IngrediantFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Ingrediant.json";
        $ingrediants = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($ingrediants));
        $progressBar->setFormat('verbose');

        foreach ($ingrediants as $infoIngrediant) {
            $ingrediant = ['nomIng' => $infoIngrediant['nomIng']];

            if (isset($infoIngrediant['nomAll'])) {
                $ingrediant['allergene'] = AllergeneFactory::random(['nomAll' => $infoIngrediant['nomAll']]);
            }

            if (isset($infoIngrediant['imgIng'])) {
                $ingrediant['imgIng'] = file_get_contents("$dir/img/ingredients/{$infoIngrediant['imgIng']}.jpg");
            }

            IngrediantFactory::createOne($ingrediant);
            $progressBar->advance();
        }

        $progressBar->finish();
    }

    public function getDependencies(): array
    {
        return [AllergeneFixtures::class];
    }
}
