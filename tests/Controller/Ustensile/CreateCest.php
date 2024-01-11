<?php

declare(strict_types=1);

namespace Controller\Ustensile;

use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function testStructure(ControllerTester $I)
    {
        $I->amOnPage('/ustensile/create');
        $I->seeResponseCodeIsSuccessful("Création d'un ustensile");
        $I->see("Création d'un ustensile", 'h1');
        $I->see("Nom de l'ustensile", 'label');
        $I->see("Image de l'ingrédient", 'label');
        $I->seeElement('input[type="submit"]');
    }

    public function createUstensile(ControllerTester $I): void
    {
        $I->amOnPage('/ustensile/create');
        $I->seeElement('form[name="ustensile"]');
        $I->submitForm('form[name="ustensile"]', [
            'ustensile[name]' => 'Batteur éléctrique',
        ], 'input[type="submit"]');
        $I->seeCurrentRouteIs('app_ustensile_show',['id'=>1]);
        $I->seeResponseCodeIsSuccessful();
    }
}
