<?php

namespace App\Controller;

use App\Entity\Ingrediant;
use App\Repository\IngrediantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngrediantController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient')]
    public function index(): Response
    {
        return $this->render('ingrediant/index.html.twig', [
            'controller_name' => 'IngrediantController',
        ]);
    }

    #[Route('/ingrediant/{id}/image', name: 'app_ingrediant_image')]
    public function showUserImage(int $id, IngrediantRepository $ingrediantRepository)
    {
        $dir = __DIR__;
        $ingrediant = $ingrediantRepository->findOneBy(['id' => $id]);
        $response = new Response();
        if (null === $ingrediant->getImgIng()) {
            $response = new Response(file_get_contents("$dir/../../public/img/icone/ingrediant_base.png"));
        } else {
            $response = new Response(stream_get_contents($ingrediant->getImgIng()));
        }
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }
}
