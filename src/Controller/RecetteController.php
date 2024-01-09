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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/recette/createQte', name: 'app_recette_createQte')]
    public function create2(EntityManagerInterface $entityManager, Request $request): Response
    {
        $ingredients = $request->getSession()->get('donnees')['ingredients'];
        $form = $this->createForm(QuantiteType::class, null, [
            'ingredients' => $ingredients,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quantites = $form->getData();
            $request->getSession()->set('quantites', $quantites);

            return $this->redirectToRoute('app_recette_createEtp');
        }

        return $this->render('recette/createIngredients.html.twig', ['form' => $form, 'ingredients' => $ingredients]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/recette/createEtp', name: 'app_recette_createEtp')]
    public function create3(EntityManagerInterface $entityManager, Request $request, $form1 = null, $form2 = null): Response
    {
        $donnees = $request->getSession()->get('donnees');
        $nbrEtapes = $donnees['nbrEtapes'];
        $form = $this->createForm(EtapeType::class, null, [
            'nbrEtapes' => $nbrEtapes,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $etapes = $form->getData();
            $recette = new Recette();

            $recette->setNomRec($donnees['nomRec']);
            $recette->setDescRec($donnees['descRec']);
            if (isset($donnees['imgRec'])) {
                $recette->setImgRec($donnees['imgRec']);
            }
            $recette->setTpsDePrep($donnees['tpsDePrep']);
            if (isset($donnees['tpsCuisson'])) {
                $recette->setTpsCuisson($donnees['tpsCuisson']);
            }
            $recette->setNbrCallo($donnees['nbrCallo']);
            $recette->setNbrPers($donnees['nbrPers']);
            $recette->setTypeRecette($entityManager->getRepository(TypeRecette::class)->find($donnees['typeRecette']));
            $recette->setPays($entityManager->getRepository(Pays::class)->find($donnees['pays']));
            $entityManager->persist($recette);
            $entityManager->flush();

            $quantites = $request->getSession()->get('quantites');
            foreach ($donnees['ingredients'] as $ingredient) {
                $quantite = new Quantite();

                $quantite->setIngredient($entityManager->getRepository(Ingredient::class)->find($ingredient));
                $quantite->setQuantite($quantites["quantiteIng{$ingredient->getId()}"]);
                $quantite->setUnitMesure($quantites["unitMesureIng{$ingredient->getId()}"]);
                $quantite->setRecette($recette);
                $entityManager->persist($quantite);
                $entityManager->flush();
            }
            $i = 1;
            foreach ($etapes as $etape) {
                $etape = new Etape();
                $etape->setNumEtape($i);
                $etape->setDescEtape($etapes["descEtape$i"]);
                $etape->setRecette($recette);
                $entityManager->persist($etape);
                $entityManager->flush();
                ++$i;
            }

            return $this->redirectToRoute('app_recette_show', ['id' => $recette->getId()]);
        }

        return $this->render('recette/createEtapes.html.twig', ['form' => $form, 'nbrEtapes' => $nbrEtapes]);
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
