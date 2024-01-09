<?php

namespace App\Controller;

use App\Entity\Ustensile;
use App\Form\UstensileType;
use App\Repository\UstensileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UstensileController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/ustensile', name: 'app_ustensile')]
    public function index(UstensileRepository $ustensileRepository): Response
    {
        $ustensiles = $ustensileRepository->findBy([], ['name' => 'ASC']);

        return $this->render('ustensile/index.html.twig', ['ustensiles' => $ustensiles]);
    }

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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/ustensile/create', name: 'app_ustensile_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $ustensile = new Ustensile();

        $form = $this->createForm(UstensileType::class, $ustensile);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ustensile = $form->getData();

            if (null !== $form->get('imgUst')->getData()) {
                $imageFile = $form->get('imgUst')->getData();
                $ustensile->setimgUst(file_get_contents($imageFile->getPathname()));
            }

            $entityManager->persist($ustensile);
            $entityManager->flush();

            return $this->redirectToRoute('app_ustensile_show', ['id' => $ustensile->getId()]);
        }

        return $this->render('ustensile/create.html.twig', ['form' => $form]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/ustensile/{id}', name: 'app_ustensile_show')]
    public function show(Ustensile $ustensile): Response
    {
        return $this->render('ustensile/show.html.twig', ['ustensile' => $ustensile]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('ustensile/{id}/update', requirements: ['ustensileId' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, Ustensile $ustensile, Request $request): Response
    {
        $form = $this->createForm(UstensileType::class, $ustensile);

        $lastImg = $ustensile->getimgUst();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ustensile = $form->getData();

            if (null !== $form->get('imgUst')->getData()) {
                $imageFile = $form->get('imgUst')->getData();
                $ustensile->setimgUst(file_get_contents($imageFile->getPathname()));
            } else {
                $ustensile->setimgUst($lastImg);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_ustensile_show', ['id' => $ustensile->getId()]);
        }

        return $this->render('ustensile/update.html.twig', ['ustensile' => $ustensile, 'form' => $form]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('ustensile/{id}/delete', requirements: ['ustensileId' => '\d+'])]
    public function delete(EntityManagerInterface $entityManager, Ustensile $ustensile, Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($ustensile);
                $entityManager->flush();

                return $this->redirectToRoute('app_home');
            } else {
                return $this->redirectToRoute('app_ustensile_show', ['id' => $ustensile->getId()]);
            }
        }

        return $this->render('ustensile/delete.html.twig', ['ustensile' => $ustensile, 'form' => $form]);
    }
}
