<?php

namespace App\Tests\Controller\User;

use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function form(ControllerTester $I): void
    {
        $I->amOnPage('/user/create');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Inscription');
        $I->see('Inscription', 'h1');
        $I->see('Email', 'label');
        $I->see('Mot de passe', 'label');
        $I->see('Répétez le mot de passe', 'label');
        $I->see('Nom', 'label');
        $I->see('Prenom', 'label');
        $I->see('Pseudo', 'label');
        $I->see('Date de naissance', 'legend');
        $I->see('Photo de profil', 'label');
        $I->see('Allergenes', 'legend');
    }
}
