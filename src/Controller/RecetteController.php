<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecetteController extends AbstractController
{
    #[Route('/recettes', name: 'app_recettes_index', methods: ['GET'])]
    public function index(RecetteRepository $recetteRepository): Response
    {
        $recommandations = $recetteRepository->recommandation();

        return $this->render('recette/index.html.twig', [
            'recettes' => $recommandations,
        ]);
    }

    #[Route('/recettes/{id}/image', name: 'app_recettes_image')]
    public function showRecetteImage(int $id, RecetteRepository $recetteRepository)
    {
        $recette = $recetteRepository->findOneBy(['id' => $id]);

        $response = new Response($this->renderView('recette/image.html.twig', [
            'image' => base64_encode(stream_get_contents($recette->getImgRec())),
            ]));

        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }
}
