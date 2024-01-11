<?php

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

class UpdateCest
{
    public function testStructurePage1(ControllerTester $I)
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

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        // Page 1
        $I->amOnPage('/recette/1/update');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle("Modification de la recette suivante: {$recette->getNomRec()}");
        $I->see("Modification de la recette suivante: {$recette->getNomRec()}", 'h1');
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
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UstensileFactory::createSequence([['name' => 'UstensileTest3'], ['name' => 'UstensileTest4']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest2'], ['nomIng' => 'IngredientTest3']]);

        $I->amOnPage('/recette/1/update');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test Modifiee',
            'recette[descRec]' => 'Description Test Modifiee',
            'recette[tpsDePrep]' => 60,
            'recette[tpsCuisson]' => 60,
            'recette[nbrCallo]' => 2500,
            'recette[nbrPers]' => 6,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest Modifié'])->getId(),
            'recette[pays]' => PaysFactory::createOne(['nomPays' => 'PaysTest Modifié'])->getId(),
            'recette[ustensiles]' => [1, 3, 4],
            'recette[ingredients]' => [2, 3],
            'recette[nbrEtapes]' => 3,
        ], 'input[type="submit"]');

        $I->seeCurrentRouteIs('app_recette_updateQte');
        $I->seeResponseCodeIsSuccessful();
    }

    public function testStructurePage2(ControllerTester $I)
    {
        $recette = RecetteFactory::createOne(['tpsCuisson' => 10,
            'pays' => PaysFactory::createOne(['nomPays' => 'PaysTest']),
            'typeRecette' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest']),
            'ustensiles' => UstensileFactory::createSequence([['name' => 'UstensileTest1'], ['name' => 'UstensileTest2']])]);
        QuantiteFactory::createOne(['recette' => $recette,
            'quantite' => 100,
            'unitMesure' => 'unitTest',
            'ingredient' => IngredientFactory::createOne(['nomIng' => 'IngredientTest1'])]);
        EtapeFactory::createSequence([['recette' => $recette, 'numEtape' => 1, 'descEtape' => 'DescTest1'], ['recette' => $recette, 'numEtape' => 2, 'descEtape' => 'DescTest2']]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UstensileFactory::createSequence([['name' => 'UstensileTest3'], ['name' => 'UstensileTest4']]);
        IngredientFactory::createSequence([['nomIng' => 'IngredientTest2'], ['nomIng' => 'IngredientTest3']]);

        $I->amOnPage('/recette/1/update');

        $I->submitForm('form[name="recette"]', [
            'recette[nomRec]' => 'Recette Test Modifiee',
            'recette[descRec]' => 'Description Test Modifiee',
            'recette[tpsDePrep]' => 60,
            'recette[tpsCuisson]' => 60,
            'recette[nbrCallo]' => 2500,
            'recette[nbrPers]' => 6,
            'recette[typeRecette]' => TypeRecetteFactory::createOne(['nomTpRec' => 'TypeRecetteTest Modifié'])->getId(),
            'recette[pays]' => PaysFactory::createOne(['nomPays' => 'PaysTest Modifié'])->getId(),
            'recette[ustensiles]' => [1, 3, 4],
            'recette[ingredients]' => [2, 3],
            'recette[nbrEtapes]' => 3,
        ], 'input[type="submit"]');

        $I->seeInTitle('Ajout des quantités pour les ingrédients');
        $I->see('Ajout des quantités pour les ingrédients', 'h1');

        $I->see('IngredientTest2', 'h2');
        $I->see('Quantité', 'label');
        $I->see('Unité de mesure', 'label');

        $I->see('IngredientTest3', 'h2');
        $I->see('Quantité', 'label');
        $I->see('Unité de mesure', 'label');
    }
}
