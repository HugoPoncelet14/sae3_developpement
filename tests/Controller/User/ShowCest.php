<?php

declare(strict_types=1);

namespace App\Tests\Controller\User;

use App\Factory\AllergeneFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    public function testStructure(ControllerTester $I): void
    {
        AllergeneFactory::createOne(['nomAll' => 'Céleri']);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'pseudo' => 'StarkTony',
                'dateNais' => new \DateTime('10-10-2022'),
                'allergenes' => [AllergeneFactory::random(['nomAll' => 'Céleri'])],
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('user/1');
        $I->seeResponseCodeIsSuccessful();

        $I->seeInTitle('Profil de Stark Tony');
        $I->see('Profil de Stark Tony', 'h1');

        $I->see('Prénom', 'dt');
        $I->see('Tony', 'dd');
        $I->see('Nom', 'dt');
        $I->see('Stark', 'dd');
        $I->see('Email', 'dt');
        $I->see('ironman@example.com', 'dd');
        $I->see('Pseudo', 'dt');
        $I->see('StarkTony', 'dd');
        $I->see('Date de naissance', 'dt');
        $I->see('10/10/2022', 'dd');
        $I->seeElement('details[id="allergies"]');
        $allergenes = $I->grabMultiple('details ul li');
        $I->assertEquals($allergenes, ['Céleri']);
        $I->seeElement('//img[@src="/user/1/image" and @alt="Photo de profil"]');

        $I->see('Modifier', '//a[@role="button" and @href="/user/1/update"]');
        $I->see('Supprimer', '//a[@role="button" and @href="/user/1/delete"]');
    }
}
