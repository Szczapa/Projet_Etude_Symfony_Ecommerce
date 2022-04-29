<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }

    #[Route('/produits', name: 'app_product')]
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();


        return $this->render('product/product.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/produits/{slug}', name: 'product_slug')]
    public function product(string $slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        
        if(!$product){
            return $this->redirectToRoute('app_product');
        }        
        
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
