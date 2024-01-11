<?php

declare(strict_types=1);

namespace Controller\Ingredient;

use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function testStructure(ControllerTester $I)
    {
        $I->amOnPage('/ingredient/create');
        $I->seeResponseCodeIsSuccessful("Création d'un ingrédient");
        $I->see("Création d'un ingrédient", 'h1');
        $I->see("Nom de l'ingrédient", 'label');
        $I->see("Image de l'ingrédient", 'label');
        $I->see('Allergene', 'label');
        $I->seeElement('div[id="ingredient_allergene"]');
        $I->seeElement('input[type="submit"]');
    }

    public function createIngredient(ControllerTester $I): void
    {
        $I->amOnPage('/ingredient/create');
        $I->seeElement('form[name="ingredient"]');
        $I->submitForm('form[name="ingredient"]', [
            'ingredient[nomIng]' => 'Patate douce',
        ], 'input[type="submit"]');
        $I->seeCurrentRouteIs('app_ingredient_create', ['id' => 1]);
        $I->seeResponseCodeIsSuccessful();
    }
}
