<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\PaysType;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PaysController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/pays', name: 'app_pays')]
    public function index(PaysRepository $paysRepository): Response
    {
        $listePays = $paysRepository->findBy([], ['nomPays' => 'ASC']);

        return $this->render('pays/index.html.twig', ['listePays' => $listePays]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/pays/create', name: 'app_pays_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $pays = new Pays();

        $form = $this->createForm(PaysType::class, $pays);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pays = $form->getData();
            $entityManager->persist($pays);
            $entityManager->flush();

            return $this->redirectToRoute('app_pays_show', ['id' => $pays->getId()]);
        }

        return $this->render('pays/create.html.twig', ['form' => $form]);
    }

    #[Route('/pays/{id}', name: 'app_pays_show')]
    public function show(pays $pays): Response
    {
        return $this->render('pays/show.html.twig', ['pays' => $pays]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('pays/{id}/update', requirements: ['paysId' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, pays $pays, Request $request): Response
    {
        $form = $this->createForm(PaysType::class, $pays);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pays = $form->getData();
            $entityManager->flush();
            return $this->redirectToRoute('app_pays_show', ['id' => $pays->getId()]);
        }
        return $this->render('pays/update.html.twig', ['pays' => $pays, 'form' => $form]);
    }
}
