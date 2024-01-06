<?php

namespace App\DataFixtures;

use App\Factory\AllergeneFactory;
use App\Factory\IngredientFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class IngredientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $dir = __DIR__;
        $file = "$dir/data/Ingredient.json";
        $ingredients = json_decode(file_get_contents($file), true);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($ingredients));
        $progressBar->setFormat('verbose');

        foreach ($ingredients as $infoingredient) {
            $ingredient = ['nomIng' => $infoingredient['nomIng']];

            if (isset($infoingredient['nomAll'])) {
                $ingredient['allergene'] = AllergeneFactory::random(['nomAll' => $infoingredient['nomAll']]);
            }

            if (isset($infoingredient['imgIng'])) {
                $ingredient['imgIng'] = file_get_contents("$dir/img/ingredients/{$infoingredient['imgIng']}.jpg");
            }

            IngredientFactory::createOne($ingredient);
            $progressBar->advance();
        }

        $progressBar->finish();
    }

    public function getDependencies(): array
    {
        return [AllergeneFixtures::class];
    }
}
