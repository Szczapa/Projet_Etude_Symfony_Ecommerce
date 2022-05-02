<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/panier', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig');
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart,$id): Response
    {
        $cart->add($id);
        return $this->render('cart/index.html.twig');
    }
}
