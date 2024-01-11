<?php

declare(strict_types=1);

namespace Controller\Ingredient;

use App\Factory\AllergeneFactory;
use App\Factory\IngredientFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    public function testStructureAdmin(ControllerTester $I)
    {
        $user = UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $ingredient = IngredientFactory::createOne([
            'nomIng' => 'patate douce',
        ]);
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ingredient/1/update');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle("Modification de l'ingredient suivant : patate douce");
        $I->see("Modification de l'ingredient suivant : patate douce", 'h1');
        $I->see("Nom de l'ingrédient", 'label');
        $I->see("Image de l'ingrédient", 'label');
        $I->see('Allergene', 'label');
        $I->seeElement('div[id="ingredient_allergene"]');
        $I->seeElement('//input[@type="submit" and @value="Modifier"]');
    }

    public function updateStrings(ControllerTester $I): void
    {
        IngredientFactory::createOne([
            'nomIng' => 'patate douce',
        ]);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'pseudo' => 'StarkTony',
                'allergenes' => [AllergeneFactory::random(['nomAll' => 'Céleri'])],
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ingredient/1/update');
        $I->submitForm('form[name="ingredient"]', [
            'ustensile[name]' => 'patate douce',
        ], 'input[type="submit"]');
        $I->seeCurrentRouteIs('app_ingredient_show', ['id' => 1]);
        $I->seeResponseCodeIsSuccessful();
        $infos = $I->grabMultiple('dd');
        $I->assertEquals($infos, ['patate douce']);
    }
}
