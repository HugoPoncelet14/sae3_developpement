<?php

namespace App\Controller\Admin;

use App\Entity\Allergene;
use App\Entity\Etape;
use App\Entity\Ingrediant;
use App\Entity\Pays;
use App\Entity\Recette;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sae3 Developpement');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Recette', 'fas fa-list', Allergene::class);
        yield MenuItem::linkToCrud('Recette', 'fas fa-list', Etape::class);
        yield MenuItem::linkToCrud('Ingrediant', 'fas fa-list', Ingrediant::class);
        yield MenuItem::linkToCrud('Ingrediant', 'fas fa-list', Pays::class);
        yield MenuItem::linkToCrud('Recette', 'fas fa-list', Recette::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
    }
}
