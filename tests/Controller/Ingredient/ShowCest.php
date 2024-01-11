<?php

declare(strict_types=1);

namespace Controller\Ingredient;

use App\Factory\IngredientFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function testStructure(ControllerTester $I)
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        IngredientFactory::createOne([
            'nomIng' => 'patate douce',
        ]);
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ingredient/1');
        $I->seeResponseCodeIsSuccessful();

        $I->seeInTitle('patate douce');
        $I->see('patate douce', 'h1');
        $I->see('Allegene associé', 'dt');
        $I->see('Aucun allergenne', 'dd');

        $I->see('Modifier', '//a[@role="button" and @href="/ustensile/1/update"]');
        $I->see('Supprimer', '//a[@role="button" and @href="/ustensile/1/delete"]');
    }

    public function testLienModification(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_USER']]
        );
        $ingredient = IngredientFactory::createOne([
            'nomIng' => 'patate douce',
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ustensile/1');
        $I->click('Modifier');
        $I->seeCurrentRouteIs("ingredient/{$ingredient->getId()}/update");
    }

    public function testLienSupression(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_USER']]
        );
        $ingredient = IngredientFactory::createOne([
            'nomIng' => 'patate douce',
        ]);
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ustensile/1');
        $I->click('Supprimer');
        $I->seeCurrentRouteIs("ingredient/{$ingredient->getId()}/delete");
    }
}
