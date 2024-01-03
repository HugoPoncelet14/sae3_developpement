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
}
