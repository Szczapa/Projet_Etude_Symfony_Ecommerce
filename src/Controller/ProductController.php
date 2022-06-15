<?php

namespace App\Controller;

use App\Classes\Search;
use App\Entity\Product;
use App\Form\SearchType as FormSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }

    #[Route('/produits', name: 'app_product')]
    public function index(Request $request): Response
    {
        
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(FormSearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $search =$form->getData();
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }

        return $this->render(
            'product/product.html.twig', [
            'products' => $products,
            'form' => $form->createView()
            ]
        );
    }

    #[Route('/produits/{slug}', name: 'product_slug')]
    public function product(string $slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $best = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        // dd($best);
        if(!$product) {
            return $this->redirectToRoute('app_product');
        }        
        
        return $this->render(
            'product/show.html.twig', [
            'product' => $product,
            'best' => $best
            ]
        );
    }
}
