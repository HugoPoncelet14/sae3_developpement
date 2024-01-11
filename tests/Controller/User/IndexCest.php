<?php

declare(strict_types=1);

namespace App\Tests\Controller\User;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function testStructure(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
            'roles' => ['ROLE_ADMIN'],
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UserFactory::createMany(5);
        $I->amOnPage('/user');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des utilisateurs');
        $I->see('Liste des utilisateurs', 'h1');

        $I->seeNumberOfElements('.listeuser li', 5);
    }

    public function testLien(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
            'roles' => ['ROLE_ADMIN'],
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        UserFactory::createOne(['nom' => 'nomTest', 'prenom' => 'prenomTest']);

        $I->amOnPage('/user');
        $I->click('nomTest prenomTest');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_user_show');
    }
}
