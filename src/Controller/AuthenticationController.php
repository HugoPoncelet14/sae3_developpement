<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends AbstractController
{
    #[Route('/auth', name: 'app_authentication')]
    public function login(): Response
    {
        return $this->render('authentication/index.html.twig', [
            'controller_name' => 'AuthenticationController',
        ]);
    }

    #[Route('/signup', name: 'app_authentication')]
    public function signup(): Response
    {
        return $this->render('authentication/signup.html.twig');
    }

}
