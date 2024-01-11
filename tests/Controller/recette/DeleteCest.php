<?php

declare(strict_types=1);

namespace App\Tests\Controller\recette;

use App\Factory\EtapeFactory;
use App\Factory\IngredientFactory;
use App\Factory\PaysFactory;
use App\Factory\QuantiteFactory;
use App\Factory\RecetteFactory;
use App\Factory\TypeRecetteFactory;
use App\Factory\UserFactory;
use App\Factory\UstensileFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    public function testStructure(ControllerTester $I): void
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2'], ['recette' => $recette, 'numEtape' => 3, 'descEtape' => 'DescTest3']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/recette/1/delete');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle("Suppression de la recette suivante : {$recette->getNomRec()}");
        $I->see("Suppression de la recette suivante : {$recette->getNomRec()}", 'h1');
        $I->see('Confirmer la supression', 'button');
        $I->see('Annuler', 'button');
    }

    public function deleteRecette(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        $quantites = QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        $etapes = EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2'], ['recette' => $recette, 'numEtape' => 3, 'descEtape' => 'DescTest3']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/recette/1/delete');
        $I->click('Confirmer la supression');
        $I->seeCurrentRouteIs('app_recettes_index');
        $I->amOnPage('/recette/1');
        $I->seeResponseCodeIs(404);
    }
}
