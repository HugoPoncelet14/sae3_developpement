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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
    #[Route('/recette/create', name: 'app_recette_create')]
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

    #[Route('/recette/{id}', name: 'app_recette_show')]
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/recette/{id}/update', name: 'app_recette_update', requirements: ['recetteId' => '\d+'])]
    public function update1(EntityManagerInterface $entityManager, Recette $recette, Request $request): Response
    {
        $form = $this->createForm(RecetteType::class);

        $ingredientsArray = new ArrayCollection();
        foreach ($recette->getQuantites() as $quantite) {
            $ingredientsArray->add($quantite->getIngredient());
        }
        $lastdatas = ['nomRec' => $recette->getNomRec(),
                      'descRec' => $recette->getDescRec(),
                      'tpsDePrep' => $recette->getTpsDePrep(),
                      'tpsCuisson' => $recette->getTpsCuisson(),
                      'nbrCallo' => $recette->getNbrCallo(),
                      'nbrPers' => $recette->getNbrPers(),
                      'typeRecette' => $recette->getTypeRecette(),
                      'pays' => $recette->getPays(),
                      'ustensiles' => $recette->getUstensiles(),
                      'ingredients' => $ingredientsArray,
                      'nbrEtapes' => count($recette->getEtapes())];

        $form->setData($lastdatas);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();
            if (null !== $donnees['imgRec']) {
                $imageFile = $donnees['imgRec'];
                $donnees['imgRec'] = file_get_contents($imageFile->getPathname());
            }
            $request->getSession()->set('donnees', $donnees);

            return $this->redirectToRoute('app_recette_updateQte', ['id' => $recette->getId()]);
        }

        return $this->render('recette/update.html.twig', ['form' => $form, 'recette' => $recette]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/recette/{id}/updateQte', name: 'app_recette_updateQte')]
    public function update2(EntityManagerInterface $entityManager, Recette $recette, Request $request): Response
    {
        $ingredients = $request->getSession()->get('donnees')['ingredients'];
        $form = $this->createForm(QuantiteType::class, null, [
            'ingredients' => $ingredients,
        ]);

        $quantites = $recette->getQuantites();

        $lastIngredientsArray = new ArrayCollection();
        foreach ($quantites as $quantite) {
            $lastIngredientsArray->add($quantite->getIngredient());
        }
        $ingredientsArray = $request->getSession()->get('donnees')['ingredients'];

        $lastdatas = [];

        foreach ($ingredientsArray as $ingredient) {
            $quantite = $entityManager->getRepository(Quantite::class)->findOneBy(['ingredient' => $ingredient, 'recette' => $recette]);
            if (null !== $quantite) {
                $lastdatas["quantiteIng{$ingredient->getId()}"] = $quantite->getQuantite();
                $lastdatas["unitMesureIng{$ingredient->getId()}"] = $quantite->getUnitMesure();
            }
        }

        $form->setData($lastdatas);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quantites = $form->getData();
            $request->getSession()->set('quantites', $quantites);

            return $this->redirectToRoute('app_recette_updateEtp', ['id' => $recette->getId()]);
        }

        return $this->render('recette/updateIngredients.html.twig', ['form' => $form, 'ingredients' => $ingredients, 'recette' => $recette]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/recette/{id}/updateEtp', name: 'app_recette_updateEtp')]
    public function update3(EntityManagerInterface $entityManager, Recette $recette, Request $request): Response
    {
        $donnees = $request->getSession()->get('donnees');
        $nbrEtapes = $donnees['nbrEtapes'];
        $form = $this->createForm(EtapeType::class, null, [
            'nbrEtapes' => $nbrEtapes,
        ]);

        $etapes = $recette->getEtapes();

        $lastdatas = [];
        $i = 1;
        foreach ($etapes as $etape) {
            if ($i <= $nbrEtapes) {
                $lastdatas["descEtape{$etape->getNumEtape()}"] = $etape->getDescEtape();
            }
            ++$i;
        }
        $form->setData($lastdatas);

        $lastIngId = new ArrayCollection();
        foreach ($recette->getQuantites() as $quantite) {
            $lastIngId->add($quantite->getIngredient()->getId());
        }
        $lastEtapesId = new ArrayCollection();
        foreach ($recette->getEtapes() as $etape) {
            $lastEtapesId->add($etape->getId());
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $etapes = $form->getData();

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

            $newIngId = new ArrayCollection();
            foreach ($donnees['ingredients'] as $ingredient) {
                $newIngId->add($ingredient->getId());
                $quantite = $entityManager->getRepository(Quantite::class)->findOneBy(['ingredient' => $ingredient, 'recette' => $recette]);

                if (null === $quantite) {
                    $quantite = new Quantite();
                    $quantite->setIngredient($entityManager->getRepository(Ingredient::class)->find($ingredient));
                    $quantite->setRecette($recette);
                }
                $quantite->setQuantite($quantites["quantiteIng{$ingredient->getId()}"]);
                if (isset($quantites["unitMesureIng{$ingredient->getId()}"])) {
                    $quantite->setUnitMesure($quantites["unitMesureIng{$ingredient->getId()}"]);
                }
                $entityManager->persist($quantite);
                $entityManager->flush();
            }
            foreach ($lastIngId as $id) {
                if (!$newIngId->contains($id)) {
                    $ingredient = $entityManager->getRepository(Ingredient::class)->findOneBy(['id' => $id]);
                    $quantite = $entityManager->getRepository(Quantite::class)->findOneBy(['ingredient' => $ingredient, 'recette' => $recette]);
                    $entityManager->remove($quantite);
                    $entityManager->flush();
                }
            }
            $i = 1;
            $newEtapesId = new ArrayCollection();
            foreach ($etapes as $etape) {
                $etape = $entityManager->getRepository(Etape::class)->findOneBy(['numEtape' => $i, 'recette' => $recette]);
                if (null === $etape) {
                    $etape = new Etape();
                    $etape->setNumEtape($i);
                    $etape->setRecette($recette);
                }
                $etape->setDescEtape($etapes["descEtape$i"]);
                $entityManager->persist($etape);
                $entityManager->flush();
                ++$i;
                $newEtapesId->add($etape->getId());
            }
            foreach ($lastEtapesId as $id) {
                if (!$newEtapesId->contains($id)) {
                    $etape = $entityManager->getRepository(Etape::class)->findOneBy(['id' => $id]);
                    $entityManager->remove($etape);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('app_recette_show', ['id' => $recette->getId()]);
        }

        return $this->render('recette/updateEtapes.html.twig', ['form' => $form, 'nbrEtapes' => $nbrEtapes, 'recette' => $recette]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('recette/{id}/delete', requirements: ['recetteId' => '\d+'])]
    public function delete(EntityManagerInterface $entityManager, Recette $recette, Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                foreach ($recette->getQuantites() as $quantite) {
                    $entityManager->remove($quantite);
                    $entityManager->flush();
                }
                foreach ($recette->getEtapes() as $etape) {
                    $entityManager->remove($etape);
                    $entityManager->flush();
                }
                $entityManager->remove($recette);
                $entityManager->flush();

                return $this->redirectToRoute('app_home');
            } else {
                return $this->redirectToRoute('app_recette_show', ['id' => $recette->getId()]);
            }
        }

        return $this->render('recette/delete.html.twig', ['recette' => $recette, 'form' => $form]);
    }
}
