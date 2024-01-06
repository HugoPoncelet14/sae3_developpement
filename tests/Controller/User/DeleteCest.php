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

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
        ]);

        $I->amOnPage('/user/1/delete');
        $I->seeCurrentRouteIs('app_login');
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

    public function accessIsRestrictedToUserUsersOnUserUsers(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_USER']]
        );

        UserFactory::createOne(['prenom' => 'Peter',
                'nom' => 'Parker',
                'email' => 'spiderman@example.com',
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();

        $I->amLoggedInAs($realuser);
        $I->amOnPage('/user/2/delete');
        $I->seeCurrentRouteIs('app_user_delete', ['id' => $realuser->getId()]);
    }

    public function AdminDeleteUser(ControllerTester $I): void
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
        $I->click('Confirmer la supression');
        $I->seeCurrentRouteIs('app_recettes_index');
        $I->amOnPage('/user/2/delete');
        $I->seeResponseCodeIs(404);
    }

    public function UserDeleteUs(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/user/1/delete');
        $I->fillField('form[password]', 'test');
        $I->click('Confirmer la supression');
        $I->seeCurrentRouteIs('app_recettes_index');
        $I->seeElement('a[class="login-button"]');
        $I->amOnPage('/user/1/delete');
        $I->seeResponseCodeIs(404);
    }
}
