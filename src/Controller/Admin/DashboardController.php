<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
     private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]   
    public function index(): Response
    {
        $routeBuilder = $this->adminUrlGenerator->setController(OrderCrudController::class)->setAction('index')->generateUrl();
        return $this->redirect($routeBuilder);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ecommerce')
        ;            
    }

    public function configureMenuItems(): iterable
    {
        return[
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            yield MenuItem::section('Gestion utilisateur'),
            yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class),

            yield MenuItem::section('Gestion Produit'),
            yield MenuItem::linkToCrud('Categories', 'fas fa-rectangle-list', Category::class),
            yield MenuItem::linkToCrud('Produits', 'fas fa-tag', Product::class),

            yield MenuItem::section('Gestion Commandes'),
            yield MenuItem::linkToCrud('Transporteur', 'fas fa-dolly', Carrier::class),
            yield MenuItem::linkToCrud('Commandes', 'fas fa-barcode', Order::class)
        ];
    }
}
