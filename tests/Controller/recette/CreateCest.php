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
}
