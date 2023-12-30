<?php

declare(strict_types=1);

namespace App\Tests\Controller\User;

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

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('user/1/update');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Modification du profil de Simpson Homer');
        $I->see('Modification du profil de Simpson Homer', 'h1');
        $I->see('Email', 'label');
        $I->see('Nom', 'label');
        $I->see('Prenom', 'label');
        $I->see('Pseudo', 'label');
        $I->see('Date de naissance', 'legend');
        $I->see('Photo de profil', 'label');
        $I->see('Allergenes', 'legend');
        $I->see('Rôle', 'legend');
        $I->seeElement('//input[@type="submit" and @value="Modifier"]');
    }

    public function testStructureUser(ControllerTester $I)
    {
        $user = UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('user/1/update');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Modification du profil de Simpson Homer');
        $I->see('Modification du profil de Simpson Homer', 'h1');
        $I->see('Email', 'label');
        $I->see('Nom', 'label');
        $I->see('Prenom', 'label');
        $I->see('Pseudo', 'label');
        $I->see('Date de naissance', 'legend');
        $I->see('Photo de profil', 'label');
        $I->see('Allergenes', 'legend');
        $I->dontSee('Rôle', 'legend');
        $I->seeElement('//input[@type="submit" and @value="Modifier"]');
    }
}
