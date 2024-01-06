<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IngredientController extends AbstractController
{
    #[Route('/ingredient/{id}/image', name: 'app_ingredient_image')]
    public function showUserImage(int $id, IngredientRepository $ingredientRepository)
    {
        $dir = __DIR__;
        $ingredient = $ingredientRepository->findOneBy(['id' => $id]);
        $response = new Response();
        if (null === $ingredient->getImgIng()) {
            $response = new Response(file_get_contents("$dir/../../public/img/icone/ingredient_base.png"));
        } else {
            $response = new Response(stream_get_contents($ingredient->getImgIng()));
        }
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/ingredient/create', name: 'app_ingredient_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $ingredient = new Ingredient();

        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            if (null !== $form->get('imgIng')->getData()) {
                $imageFile = $form->get('imgIng')->getData();
                $ingredient->setimgIng(file_get_contents($imageFile->getPathname()));
            }

            $entityManager->persist($ingredient);
            $entityManager->flush();

            return $this->redirectToRoute('app_ingredient_show', ['id' => $ingredient->getId()]);
        }

        return $this->render('ingredient/create.html.twig', ['form' => $form]);
    }

    #[Route('/ingredient/{id}', name: 'app_ingredient_show')]
    public function show(Ingredient $ingredient): Response
    {
        return $this->render('ingredient/show.html.twig', ['ingredient' => $ingredient]);
    }


}
