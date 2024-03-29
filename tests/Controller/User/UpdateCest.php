<?php

declare(strict_types=1);

namespace App\Tests\Controller\User;

use App\Factory\AllergeneFactory;
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
        $I->see('allergies', 'details');
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
        $I->see('allergies', 'details');
        $I->dontSee('Rôle', 'legend');
        $I->seeElement('//input[@type="submit" and @value="Modifier"]');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        UserFactory::createOne([
            'prenom' => 'Homer',
            'nom' => 'Simpson',
        ]);

        $I->amOnPage('/user/1/update');
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

        $I->amOnPage('/user/2/update');

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
        $I->amOnPage('/user/2/update');
        $I->seeResponseCodeIsSuccessful();
    }

    public function updateStrings(ControllerTester $I): void
    {
        AllergeneFactory::createOne(['nomAll' => 'Céleri']);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'pseudo' => 'StarkTony',
                'allergenes' => [AllergeneFactory::random(['nomAll' => 'Céleri'])],
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('user/1/update');
        $I->submitForm('form[name="user"]', [
            'user[nom]' => 'testNom',
            'user[prenom]' => 'testPrenom',
            'user[email]' => 'test@email.com',
            'user[pseudo]' => 'testPseudo',
        ], 'input[type="submit"]');
        $I->seeCurrentRouteIs('app_user_show', ['id' => 1]);
        $I->seeResponseCodeIsSuccessful();
        $infos = $I->grabMultiple('dd');
        $I->assertEquals($infos, ['testPrenom', 'testNom', 'test@email.com', 'testPseudo', 'Aucune date de naissance renseignée']);
        $allergenes = $I->grabMultiple('details ul li');
        $I->assertEquals($allergenes, ['Céleri']);
    }

    public function updateAllergenes(ControllerTester $I): void
    {
        AllergeneFactory::createOne(['nomAll' => 'Céleri']);
        AllergeneFactory::createOne(['nomAll' => 'Arachide']);
        AllergeneFactory::createOne(['nomAll' => 'Poisson']);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'pseudo' => 'StarkTony',
                'allergenes' => [AllergeneFactory::random(['nomAll' => 'Arachide'])],
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('user/1/update');
        $I->submitForm('form[name="user"]', [
            'user[allergenes][1]' => true,
        ], 'input[type="submit"]');
        $I->seeCurrentRouteIs('app_user_show', ['id' => 1]);
        $I->seeResponseCodeIsSuccessful();
        $infos = $I->grabMultiple('dd');
        $I->assertEquals($infos, ['Tony', 'Stark', 'ironman@example.com', 'StarkTony', 'Aucune date de naissance renseignée']);
        $allergenes = $I->grabMultiple('details ul li');
        $I->assertEquals($allergenes, ['Céleri', 'Arachide']);
    }

    public function updateDateDeNaissance(ControllerTester $I): void
    {
        AllergeneFactory::createOne(['nomAll' => 'Céleri']);

        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'pseudo' => 'StarkTony',
                'allergenes' => [AllergeneFactory::random(['nomAll' => 'Céleri'])],
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('user/1/update');
        $I->submitForm('form[name="user"]', [
            'user[dateNais][day]' => '1',
            'user[dateNais][month]' => '1',
            'user[dateNais][year]' => '2024',
        ], 'input[type="submit"]');
        $I->seeCurrentRouteIs('app_user_show', ['id' => 1]);
        $I->seeResponseCodeIsSuccessful();
        $infos = $I->grabMultiple('dd');
        $I->assertEquals($infos, ['Tony', 'Stark', 'ironman@example.com', 'StarkTony', '01/01/2024']);
        $allergenes = $I->grabMultiple('details ul li');
        $I->assertEquals($allergenes, ['Céleri']);
    }

    public function updateRoles(ControllerTester $I): void
    {
        AllergeneFactory::createOne(['nomAll' => 'Céleri']);

        $user = UserFactory::createOne(['prenom' => 'Homer',
                'nom' => 'Simpson',
                'roles' => ['ROLE_ADMIN']]);

        $usertest = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'ironman@example.com',
                'pseudo' => 'StarkTony',
                'allergenes' => [AllergeneFactory::random(['nomAll' => 'Céleri'])],
                'roles' => ['ROLE_USER']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('user/2/update');
        $I->submitForm('form[name="user_type_admin"]', [
            'user_type_admin[roles]' => ['ROLE_ADMIN'],
        ], 'input[type="submit"]');

        $I->seeCurrentRouteIs('app_recettes_index');
        $I->seeResponseCodeIsSuccessful();
        $I->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $usertest->getRoles());
    }
}
