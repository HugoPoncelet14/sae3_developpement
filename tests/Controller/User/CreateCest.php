<?php

namespace App\Tests\Controller\User;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function testStructure(ControllerTester $I): void
    {
        $I->amOnPage('/signup');
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
        $I->seeElement('div[id="user_type_create_allergenes"]');
        $I->seeElement('input[type="submit"]');
    }

    public function accessIsRestrictedToNotAuthenticatedUsers(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
        ]);

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/signup');
        $I->seeCurrentRouteIs('app_recettes_index');
    }

    public function createUser(ControllerTester $I): void
    {
        $I->amOnPage('/signup');
        $I->seeElement('form[name="user_type_create"]');
        $I->submitForm('form[name="user_type_create"]', [
            'user_type_create[prenom]' => 'Homer',
            'user_type_create[nom]' => 'Simpson',
            'user_type_create[email]' => 'test@gmail.com',
            'user_type_create[password][first]' => 'test',
            'user_type_create[password][second]' => 'test',
            'user_type_create[pseudo]' => 'hs',
        ], 'input[type="submit"]');
        $I->seeCurrentRouteIs('app_login');
        $I->submitForm('form[id="auth"]', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ], 'button[type="submit"]');
        $I->seeCurrentRouteIs('app_user_show', ['id' => 1]);
        $I->seeResponseCodeIsSuccessful();
    }
}
