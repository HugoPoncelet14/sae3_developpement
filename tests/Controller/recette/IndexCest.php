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

    public function testLiens(ControllerTester $I): void
    {
        RecetteFactory::createOne(['nomRec' => 'RecetteTest', 'tpsDePrep' => 70]);
        RecetteFactory::createOne(['nomRec' => 'RecetteTestRapide', 'tpsDePrep' => 10, 'tpsCuisson' => 10]);
        RecetteFactory::createMany(15, ['tpsDePrep' => 10, 'tpsCuisson' => 10]);
        // Test lien recette dans recommandations
        $I->amOnPage('/recettes');
        $I->click('RecetteTest');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_recette_show');
        // Test lien recherche par type
        $I->amOnPage('/recettes');
        $I->click('Entrée', 'a[id="search-button"]');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_recette_filter');
        // Test lien recette dans recettes rapides
        $I->amOnPage('/recettes');
        $I->click('RecetteTestRapide');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_recette_show');
        // Test lien vers toutes les recettes rapides
        $I->amOnPage('/recettes');
        $I->click('Voir toutes les recettes rapides', 'a[id="voir-tout"]');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_recettes_rapides');
    }

    public function search(Controllertester $I): void
    {
        RecetteFactory::createSequence([['nomRec' => 'Recette1'], ['nomRec' => 'Recette2'], ['nomRec' => 'Recette30'], ['nomRec' => 'Recette31'], ['nomRec' => 'Recette4']]);
        $I->amOnPage('/recettes');
        $I->seeResponseCodeIsSuccessful();
        $I->submitForm('.d-flex', ['search' => '3']);
        $I->amOnPage('/recette_recherche?search=3');
        $links = $I->grabMultiple('h5');
        $I->assertEquals($links, ['Recette30', 'Recette31']);
    }
}
