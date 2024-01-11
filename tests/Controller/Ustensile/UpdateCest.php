<?php

declare(strict_types=1);

namespace Controller\Ustensile;

use App\Factory\AllergeneFactory;
use App\Factory\UserFactory;
use App\Factory\UstensileFactory;
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
        $ustensile = UstensileFactory::createOne([
            'name' => 'batteur',
        ]);
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ustensile/1/update');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle("Modification de l'ustensile suivant : batteur");
        $I->see("Modification de l'ustensile suivant : batteur", 'h1');
        $I->see("Nom de l'ustensile", 'label');
        $I->see("Image de l'ingrédient", 'label');
        $I->seeElement('//input[@type="submit" and @value="Modifier"]');
    }

    public function updateStrings(ControllerTester $I): void
    {
        UstensileFactory::createOne([
            'name' => 'batteur',
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

        $I->amOnPage('ustensile/1/update');
        $I->submitForm('form[name="ustensile"]', [
            'ustensile[name]' => 'batteur',
        ], 'input[type="submit"]');
        $I->seeCurrentRouteIs('app_ustensile_show', ['id' => 1]);
        $I->seeResponseCodeIsSuccessful();
        $infos = $I->grabMultiple('dd');
        $I->assertEquals($infos, ['batteur']);
    }
}
