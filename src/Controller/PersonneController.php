<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    #[Route('/admin')]
    public function admin(PersonneRepository $personneRepository): Response
    {
        $qb = $personneRepository->createQueryBuilder('p')
            ->innerJoin('p.typePersonne', 't')
            ->where("t.nomTpPers = 'Administrateur'");
        $admins = $qb->getQuery()->execute();

        return $this->render('personne/admin.html.twig', [
            'controller_name' => 'AdminController',
            'admins' => $admins,
        ]);
    }

    #[Route('/user')]
    public function users(PersonneRepository $personneRepository): Response
    {
        $qb = $personneRepository->createQueryBuilder('p')
            ->innerJoin('p.typePersonne', 't')
            ->where("t.nomTpPers = 'Utilisateur'");
        $users = $qb->getQuery()->execute();

        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
            'users' => $users,
        ]);
    }

    #[Route('/user/create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('personne/create.html.twig');
    }

    #[Route('user/{id}/update', requirements: ['personneId' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, Personne $personne, Request $request): Response
    {
        return $this->render('personne/update.html.twig', ['contact' => $personne]);
    }

    #[Route('user/{id}/delete', requirements: ['personneId' => '\d+'])]
    public function delete(EntityManagerInterface $entityManager, Personne $personne, Request $request): Response
    {
        return $this->render('personne/delete.html.twig', ['contact' => $personne]);
    }
}
