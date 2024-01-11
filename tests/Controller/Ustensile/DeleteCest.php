<?php

declare(strict_types=1);

namespace Controller\Ustensile;

use App\Factory\UserFactory;
use App\Factory\UstensileFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    public function testStructure(ControllerTester $I)
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        UstensileFactory::createOne([
            'name' => 'batteur',
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/ustensile/1/delete');
        $I->seeResponseCodeIsSuccesful();
        $I->seeInTitle("Suppression de l'ustensile suivant : batteur");
        $I->see("Suppression de l'ustensile suivant : batteur");
        $I->see('Confirmer la supression', 'button');
        $I->see('Annuler', 'button');
    }

    public function AdminDeleteUstensile(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        UstensileFactory::createOne([
            'name' => 'batteur',
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/ustensile/1/delete');
        $I->click('Confirmer la supression');
        $I->seeCurrentRouteIs('app_recettes_index');
        $I->amOnPage('/ustensile/1/delete');
        $I->seeResponseCodeIs(404);
    }
    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
        ]);

        UstensileFactory::createOne([
            'name' => 'batteur',
        ]);

        $I->amOnPage('/ustensile/1/delete');
        $I->seeCurrentRouteIs('app_login');
    }
}