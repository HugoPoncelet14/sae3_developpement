<?php

declare(strict_types=1);

namespace Controller\Ustensile;

use App\Factory\UserFactory;
use App\Factory\UstensileFactory;
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

        UstensileFactory::createOne([
            'name' => 'batteur',
        ]);
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ustensile/1');
        $I->seeResponseCodeIsSuccessful();

        $I->seeInTitle('batteur');
        $I->see('batteur', 'h1');

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
        $ustensile = UstensileFactory::createOne([
            'name' => 'batteur',
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ustensile/1');
        $I->click('Modifier');
        $I->seeCurrentRouteIs("ustensile/{$ustensile->getId()}/update");
    }
    public function testLienSupression(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'roles' => ['ROLE_USER']]
        );
        $ustensile = UstensileFactory::createOne([
            'name' => 'batteur',
        ]);
        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('ustensile/1');
        $I->click('Supprimer');
        $I->seeCurrentRouteIs("ustensile/{$ustensile->getId()}/delete");
    }
}
