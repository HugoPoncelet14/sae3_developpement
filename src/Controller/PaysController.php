<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\PaysType;
use App\Repository\PaysRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PaysController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/pays', name: 'app_pays')]
    public function index(PaysRepository $paysRepository): Response
    {
        $listePays = $paysRepository->findBy([], ['nomPays' => 'ASC']);

        return $this->render('pays/index.html.twig', ['listePays' => $listePays]);
    }
}
