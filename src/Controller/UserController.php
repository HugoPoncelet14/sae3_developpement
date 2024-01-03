<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserTypeAdmin;
use App\Form\UserTypeCreate;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/user/{id}/image', name: 'app_user_image')]
    public function showUserImage(int $id, UserRepository $userRepository)
    {
        $dir = __DIR__;
        $user = $userRepository->findOneBy(['id' => $id]);
        $response = new Response();
        if (null === $user->getPhotoProfil()) {
            $response = new Response(file_get_contents("$dir/../../public/img/icone/profile_base.png"));
        } else {
            $response = new Response(stream_get_contents($user->getPhotoProfil()));
        }
        $response->headers->set('Content-Type', 'image/png');

        return $response;
    }

    #[Route('/signup')]
    public function create(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_home');
        }
        $user = new User();

        $form = $this->createForm(UserTypeCreate::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            if (null !== $form->get('photoProfil')->getData()) {
                $imageFile = $form->get('photoProfil')->getData();
                $user->setPhotoProfil(file_get_contents($imageFile->getPathname()));
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }

        return $this->render('user/create.html.twig', ['form' => $form]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/user/{id}', requirements: ['userId' => '\d+'])]
    public function show(User $user): Response
    {
        $currentUser = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            if ($currentUser !== $user) {
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    return $this->redirectToRoute('app_home');
                }
            }
        } else {
            if ($currentUser !== $user) {
                return $this->redirectToRoute('app_user_show', ['id' => $currentUser->getId()]);
            }
        }

        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('user/{id}/update', requirements: ['userId' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, User $user, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $currentUser = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(UserTypeAdmin::class, $user);
            if ($currentUser !== $user) {
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    return $this->redirectToRoute('app_home');
                }
            }
        } else {
            $form = $this->createForm(UserType::class, $user);

            if ($currentUser !== $user) {
                return $this->redirectToRoute('app_user_update', ['id' => $currentUser->getId()]);
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

            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }

        return $this->render('user/update.html.twig', ['user' => $user, 'form' => $form]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('user/{id}/delete', requirements: ['userId' => '\d+'])]
    public function delete(EntityManagerInterface $entityManager, User $user, Request $request, TokenStorageInterface $tokenStorage): Response
    {
        $currentUser = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            if ($currentUser !== $user) {
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    return $this->redirectToRoute('app_home');
                }
            }
        } else {
            if ($currentUser !== $user) {
                return $this->redirectToRoute('app_user_delete', ['id' => $currentUser->getId()]);
            }
        }

        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($user);
                $entityManager->flush();
                if ($currentUser === $user) {
                    $tokenStorage->setToken(null);
                }

                return $this->redirectToRoute('app_home');
            } else {
                return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
            }
        }

        return $this->render('user/delete.html.twig', ['user' => $user, 'form' => $form]);
    }
}
