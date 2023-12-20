<?php

namespace App\Tests\Controller\User;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    public function form(ControllerTester $I): void
    {
        $user = UserFactory::createOne(['prenom' => 'Tony',
                'nom' => 'Stark',
                'email' => 'root@example.com',
                'roles' => ['ROLE_ADMIN']]
        );

        $realuser = $user->object();
        $I->amLoggedInAs($realuser);

        $I->amOnPage('/user/1/delete');
        $I->seeInTitle('Suppression de Stark, Tony');
        $I->see('Suppression de Stark, Tony', 'h1');
    }
}
