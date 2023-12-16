<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\SearchData;
use App\Form\SearchForm;
use App\Repository\EtapeRepository;
use App\Repository\QuantiteRepository;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecetteController extends AbstractController
{
    #[Route('/recettes', name: 'app_recettes_index', methods: ['GET'])]
    public function index(RecetteRepository $recetteRepository): Response
    {
        $recommandations = $recetteRepository->recommandation();

        return $this->render('recette/index.html.twig', [
            'controller_name' => 'RecetteController',
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

    #[Route('/recettes/{id}', name: 'app_recette_details')]
    public function recetteDetails(Recette $recette, QuantiteRepository $quantiteRepository, EtapeRepository $etapeRepository, int $id): Response
    {
        $quantites = $quantiteRepository->AllQuantiteByRecetteId($id);
        $etapes = $etapeRepository->getAllEtapeWithRecetteId($id);
        dump(count($etapes));

        return $this->render('recette/details.html.twig', [
            'recette' => $recette,
            'quantites' => $quantites,
            'etapes' => $etapes,
        ]);
    }

    #[Route('/recette_recherche', name: 'app_recette_search')]
    public function search(RecetteRepository $recetteRepository, Request $request): Response
    {
        $recherche = $request->query->get('search', ' ');
        $recettes = $recetteRepository->search($recherche);

        return $this->render('recette/search.html.twig', [
            'recettes' => $recettes,
            'search' => $recherche,
        ]);
    }

    #[Route('/filter', name: 'app_recette_filter')]
    public function recettesFilter(RecetteRepository $recetteRepository, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $recettes = $recetteRepository->findSearch($data);

        return $this->render('recette/filter.html.twig', [
            'recettes' => $recettes,
            'form' => $form->createView(),
        ]);
    }
}
