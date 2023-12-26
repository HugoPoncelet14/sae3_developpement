<?php

namespace App\Tests\Controller\User;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    public function testStructure(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/user/1/delete');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Suppression de Simpson, Homer');
        $I->see('Suppression de Simpson, Homer', 'h1');
        $I->see('Confirmer la supression', 'button');
        $I->see('Annuler', 'button');
    }

    public function form(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/user/1/delete');
        $I->seeInTitle('Suppression de Stark, Tony');
        $I->see('Suppression de Stark, Tony', 'h1');
    }

    public function accessIsRestrictedToAdminUsersOnAdminUsers(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        UserFactory::createOne(['prenom' => 'Peter',
                'nom' => 'Parker',
                'email' => 'spiderman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        $realuser = $user->object();

        $I->amLoggedInAs($realuser);

        $I->amOnPage('/user/2/delete');

        $I->seeCurrentRouteIs('app_recettes_index');
    }

    public function accessIsRestrictedToAdminUsersOnUserUsers(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        UserFactory::createOne(['prenom' => 'Peter',
                'nom' => 'Parker',
                'email' => 'spiderman@example.com',
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();

        $I->amLoggedInAs($realuser);
        $I->amOnPage('/user/2/delete');
        $I->seeResponseCodeIsSuccessful();
    }

}
