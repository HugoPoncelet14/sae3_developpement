<?php

namespace App\Controller;

use App\Entity\Ustensile;
use App\Form\UstensileType;
use App\Repository\UstensileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UstensileController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/ustensile/{id}/image', name: 'app_ustensile_image')]
    public function showUstensileImage(int $id, UstensileRepository $ustensileRepository)
    {
        $dir = __DIR__;
        $ustensile = $ustensileRepository->findOneBy(['id' => $id]);
        $response = new Response();
        if (null === $ustensile->getImgUst()) {
            $response = new Response(file_get_contents("$dir/../../public/img/icone/ustensile_base.png"));
        } else {
            $response = new Response(stream_get_contents($ustensile->getImgUst()));
        }
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }

    #[Route('/ustensile/{id}', name: 'app_ustensile_show')]
    public function show(Ustensile $ustensile): Response
    {
        return $this->render('ustensile/show.html.twig', ['ustensile' => $ustensile]);
    }
}
