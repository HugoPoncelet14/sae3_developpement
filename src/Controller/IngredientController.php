<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    #[Route('/ingrediet/{id}/image', name: 'app_ingredient_image')]
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

    #[Route('/ingredient/{id}', name: 'app_ingredient_show')]
    public function show(Ingredient $ingredient): Response
    {
        return $this->render('ingredient/show.html.twig', ['ingredient' => $ingredient]);
    }
}
