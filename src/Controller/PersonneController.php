<?php

namespace App\Controller;

use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}
