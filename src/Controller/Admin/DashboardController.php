<?php

namespace App\Controller\Admin;

use App\Entity\Allergene;
use App\Entity\Etape;
use App\Entity\Ingrediant;
use App\Entity\Pays;
use App\Entity\Quantite;
use App\Entity\Recette;
use App\Entity\Region;
use App\Entity\TypeRecette;
use App\Entity\User;
use App\Entity\Ustensile;
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
        yield MenuItem::linkToCrud('Allergene', 'fas fa-list', Allergene::class);
        yield MenuItem::linkToCrud('Recette', 'fas fa-list', Etape::class);
        yield MenuItem::linkToCrud('Ingrediant', 'fas fa-list', Ingrediant::class);
        yield MenuItem::linkToCrud('Pays', 'fas fa-list', Pays::class);
        yield MenuItem::linkToCrud('Quantite', 'fas fa-list', Quantite::class);
        yield MenuItem::linkToCrud('Recette', 'fas fa-list', Recette::class);
        yield MenuItem::linkToCrud('Region', 'fas fa-list', Region::class);
        yield MenuItem::linkToCrud('Type Recette', 'fas fa-list', TypeRecette::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Ustansile', 'fas fa-list', Ustensile::class);
    }
}
