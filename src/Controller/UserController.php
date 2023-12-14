<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('user/create.html.twig');
    }

    #[Route('/user/{id}', requirements: ['userId' => '\d+'])]
    public function show(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('user/create.html.twig');
    }

    #[Route('user/{id}/update', requirements: ['userId' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, User $user, Request $request): Response
    {
        return $this->render('user/update.html.twig', ['user' => $user]);
    }

    #[Route('user/{id}/delete', requirements: ['userId' => '\d+'])]
    public function delete(EntityManagerInterface $entityManager, User $user, Request $request): Response
    {
        return $this->render('user/delete.html.twig', ['user' => $user]);
    }
}
