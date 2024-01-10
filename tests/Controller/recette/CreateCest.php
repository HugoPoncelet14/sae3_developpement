<?php

declare(strict_types=1);

namespace App\Tests\Controller\recette;

use App\Factory\IngredientFactory;
use App\Factory\PaysFactory;
use App\Factory\TypeRecetteFactory;
use App\Factory\UserFactory;
use App\Factory\UstensileFactory;
use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function testStructurePage1(ControllerTester $I)
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        // Page 1
        $I->amOnPage('/recette/create');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle("Création d'une recette");
        $I->see("Création d'une recette", 'h1');
        $I->see('Nom de la recette', 'label');
        $I->see('Description de la recette', 'label');
        $I->see('Image de la recette', 'label');
        $I->see('Temps de préparation', 'label');
        $I->see('Temps de cuisson', 'label');
        $I->see('Nombre de personne(s)', 'label');
        $I->see('Type de la recette', 'label');
        $I->see("Pays d'origine", 'label');
        $I->see('Créer un nouveau pays', 'a[href]');
        $I->see('Ustensiles', 'legend');
        $I->see('Créer un nouvel ustensile', 'a[href]');
        $I->see('Ingredients', 'legend');
        $I->see('Créer un nouvel ingrédient', 'a[href]');
        $I->see("Nombre d'étapes", 'label');
        $I->seeElement('input[type="submit"]');
    }

    public function testSubmitFormPage1(ControllerTester $I)
    {
        UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest1'], ['nomIng' => 'IngredientTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/recette/create');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test',
            'recette[descRec]' => 'Description Test',
            'recette[tpsDePrep]' => 20,
            'recette[tpsCuisson]' => 30,
            'recette[nbrCallo]' => 1500,
            'recette[nbrPers]' => 4,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(),
            'recette[pays]' => PaysFactory::createOne(),
            'recette[ustensiles][1]' => true,
            'recette[ustensiles][2]' => true,
            'recette[ingredients][1]' => true,
            'recette[ingredients][2]' => true,
            'recette[nbrEtapes]' => 4,
        ], 'input[type="submit"]');

        $I->seeCurrentRouteIs('app_recette_createQte');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testStructurePage2(ControllerTester $I)
    {
        UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest1'], ['nomIng' => 'IngredientTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/recette/create');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test',
            'recette[descRec]' => 'Description Test',
            'recette[tpsDePrep]' => 20,
            'recette[tpsCuisson]' => 30,
            'recette[nbrCallo]' => 1500,
            'recette[nbrPers]' => 4,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(),
            'recette[pays]' => PaysFactory::createOne(),
            'recette[ustensiles]' => [1, 2],
            'recette[ingredients]' => [1, 2],
            'recette[nbrEtapes]' => 4,
        ], 'input[type="submit"]');

        $I->seeInTitle('Ajout des quantités pour les ingrédients');
        $I->see('Ajout des quantités pour les ingrédients', 'h1');

        $I->see('IngredientTest1', 'h2');
        $I->see('Quantité', 'label');
        $I->see('Unité de mesure', 'label');

        $I->see('IngredientTest2', 'h2');
        $I->see('Quantité', 'label');
        $I->see('Unité de mesure', 'label');
    }
}
