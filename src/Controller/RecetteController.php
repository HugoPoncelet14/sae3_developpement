<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Entity\Ingredient;
use App\Entity\Pays;
use App\Entity\Quantite;
use App\Entity\Recette;
use App\Entity\TypeRecette;
use App\Form\EtapeType;
use App\Form\QuantiteType;
use App\Form\RecetteType;
use App\Form\SearchData;
use App\Form\SearchForm;
use App\Repository\EtapeRepository;
use App\Repository\QuantiteRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RecetteController extends AbstractController
{
    #[Route('/recettes', name: 'app_recettes_index', methods: ['GET'])]
    public function index(RecetteRepository $recetteRepository): Response
    {
        $recommandations = $recetteRepository->recommandation();
        $recettes_rapides = $recetteRepository->fastRecipe();

        return $this->render('recette/index.html.twig', [
            'controller_name' => 'RecetteController',
            'recettes' => $recommandations,
            'recettesRapides' => $recettes_rapides,
        ]);
    }

    #[Route('/recettes/{id}/image', name: 'app_recettes_image')]
    public function showRecetteImage(int $id, RecetteRepository $recetteRepository)
    {
        $recette = $recetteRepository->findOneBy(['id' => $id]);

        $response = new Response(stream_get_contents($recette->getImgRec()));
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/recette/create', name: 'app_pays_create1')]
    public function create1(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(RecetteType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();
            if (null !== $donnees['imgRec']) {
                $imageFile = $donnees['imgRec'];
                $donnees['imgRec'] = file_get_contents($imageFile->getPathname());
            }
            $request->getSession()->set('donnees', $donnees);

            return $this->redirectToRoute('app_recette_createQte');
        }

        return $this->render('recette/create.html.twig', ['form' => $form]);
    }

    #[Route('/recettes/{id}', name: 'app_recette_show')]
    public function show(Recette $recette, QuantiteRepository $quantiteRepository, EtapeRepository $etapeRepository, int $id): Response
    {
        $quantites = $quantiteRepository->AllQuantiteByRecetteId($id);
        $etapes = $etapeRepository->getAllEtapeWithRecetteId($id);

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

    #[Route('/recettes-rapides', name: 'app_recettes_rapides')]
    public function recettesRapides(RecetteRepository $recetteRepository): Response
    {
        $recettesRapides = $recetteRepository->fastRecipe();

        return $this->render('recette/rapides.html.twig', [
            'recettes' => $recettesRapides,
            'count' => count($recettesRapides),
        ]);
    }
}
