<?php

namespace App\Tests\Controller\recette;

use App\Factory\RecetteFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function testStructure(ControllerTester $I): void
    {
        RecetteFactory::createMany(15, ['tpsDePrep' => 10, 'tpsCuisson' => 10]);
        $I->amOnPage('/recettes');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Cuisinisi');
        $I->see('Nos recommandations', 'h1');
        $I->seeNumberOfElements('.recommandations_container a.recipe_container', 5);
        $I->see('Recherche par type', 'h1');
        $I->seeNumberOfElements('.type-search_container a[id="search-button"]', 4);
        $I->see('Recettes rapides', 'h1');
        $I->see('Voir toutes les recettes rapides', 'a[href]');
        $I->seeNumberOfElements('.fast-recipe_parent-container a.recipe_container', 8);
    }
}
