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
        yield MenuItem::section('Menu Principal');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Localisation');
        yield MenuItem::linkToCrud('Pays', 'fas fa-earth-europe', Pays::class);
        yield MenuItem::linkToCrud('Region', 'fas fa-flag', Region::class);
        yield MenuItem::section('Recette');
        yield MenuItem::linkToCrud('Allergene', 'fas fa-skull-crossbones', Allergene::class);
        yield MenuItem::linkToCrud('Etape', 'fas fa-list-check', Etape::class);
        yield MenuItem::linkToCrud('Ingrediant', 'fas fa-egg', Ingrediant::class);
        yield MenuItem::linkToCrud('Quantite', 'fas fa-scale-balanced', Quantite::class);
        yield MenuItem::linkToCrud('Recette', 'fas fa-pizza-slice', Recette::class);
        yield MenuItem::linkToCrud('Type Recette', 'fas fa-cake-candles', TypeRecette::class);
        yield MenuItem::linkToCrud('Ustansile', 'fas fa-utensils', Ustensile::class);
        yield MenuItem::section('Utilisateur');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);

    }
}
