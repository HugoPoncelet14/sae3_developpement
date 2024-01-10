<?php

namespace App\Tests\Controller\recette;

use App\Factory\EtapeFactory;
use App\Factory\IngredientFactory;
use App\Factory\PaysFactory;
use App\Factory\QuantiteFactory;
use App\Factory\RecetteFactory;
use App\Factory\TypeRecetteFactory;
use App\Factory\UstensileFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function testStructure(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
                                   'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
                                   'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
                                   'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
                                    'quantite' => 100,
                                    'unitMesure' => 'unitTest',
                                    'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2']]);
        $I->amOnPage('/recettes/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeElement("img[alt='Image de {$recette->getNomRec()}']");
        $I->see($recette->getNomRec(), 'h1');
        $I->see($recette->getDescRec(), 'div');
        $I->see("Temps de préparation: {$recette->getTpsDePrep()} min", 'span');
        $I->see("Temps de cuisson: {$recette->getTpsCuisson()} min", 'span');
        $I->see('Ingredients', 'h2');
        $I->seeNumberOfElements('.ingredient ul li', 1);
        $I->see('100 unitTest IngredientTest');
        $I->seeNumberOfElements('p', 2);
        $numEtapes = $I->grabMultiple('h3');
        $I->assertEquals($numEtapes, ['Etape 1', 'Etape 2']);
        $descEtapes = $I->grabMultiple('p');
        $I->assertEquals($descEtapes, ['DescTest1', 'DescTest2']);
    }
}
