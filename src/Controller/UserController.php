<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserTypeAdmin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('user/create.html.twig');
    }

    #[Route('/user/{id}', requirements: ['userId' => '\d+'])]
    public function show(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('user/show.html.twig');
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('user/{id}/update', requirements: ['userId' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, User $user, Request $request, UserPasswordHasherInterface $passwordHasher, AuthorizationCheckerInterface $authorizationChecker): Response
    {
        $currentUser = $this->getUser();

        if ($authorizationChecker->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(UserTypeAdmin::class, $user);
            if ($currentUser !== $user) {
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    throw $this->createAccessDeniedException('Vous n\'avez pas l\'autorisation de modifier les informations d\'un autre administrateur.');
                }
            }
        } else {
            $form = $this->createForm(UserType::class, $user);

            if ($currentUser !== $user) {
                throw $this->createAccessDeniedException('Vous n\'avez pas l\'autorisation de modifier ces informations.');
            }
        }
        $lastpp = $user->getPhotoProfil();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            if (null !== $form->get('photoProfil')->getData()) {
                $imageFile = $form->get('photoProfil')->getData();
                $user->setPhotoProfil(file_get_contents($imageFile->getPathname()));
            } else {
                $user->setPhotoProfil($lastpp);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_user_update', ['id' => $user->getId()]);
        }

        return $this->render('user/update.html.twig', ['user' => $user, 'form' => $form]);
    }

    #[Route('user/{id}/delete', requirements: ['userId' => '\d+'])]
    public function delete(EntityManagerInterface $entityManager, User $user, Request $request): Response
    {
        return $this->render('user/delete.html.twig', ['user' => $user]);
    }
}
