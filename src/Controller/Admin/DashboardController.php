<?php
namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Commande;
use App\Entity\User;
use App\Controller\Admin\ArticlesCrudController;
use App\Entity\Couleurs;
use App\Entity\Tailles;
use App\Entity\Types;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_ADMIN')]

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {     
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator
        ->setController(ArticlesCrudController::class)
        ->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dev');
    }

   public function configureMenuItems(): iterable {
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

    yield MenuItem::section('Gestion du catalogue');
    yield MenuItem::linkToCrud('Articles', 'fas fa-box', Articles::class);

    yield MenuItem::section('Gestion couleurs, type et tailles');
    yield MenuItem::linkToCrud('Couleurs', 'fa fa-palette', Couleurs::class);
    yield MenuItem::linkToCrud('Tailles', 'fa fa-ruler', Tailles::class);
    yield MenuItem::linkToCrud('Types', 'fa fa-tags', Types::class);

    yield MenuItem::section('Commandes');
    yield MenuItem::linkToCrud('Commandes', 'fas fa-shopping-cart', Commande::class);

    yield MenuItem::section('Utilisateurs');
    yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);


    yield MenuItem::section('Retour au site');
    yield MenuItem::linkToUrl('Page d’accueil', 'fas fa-home', '/');
}


}
