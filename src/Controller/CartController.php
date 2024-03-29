<?php

namespace App\Controller;

use App\Classes\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// use App\Entity\Product;
// use Doctrine\ORM\EntityManagerInterface;

class CartController extends AbstractController
{
    #[Route('/panier', name: 'cart')]
    public function index(CartManager $cart): Response
    {
        return $this->render(
            'cart/cart.html.twig',
            [
            'cart' => $cart->getFull()

            ]
        );
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(CartManager $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/decrease/{id}', name: 'decrease_to_cart')]
    public function decrease(CartManager $cart, $id): Response
    {
        $cart->decrease($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(CartManager $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }

    #[Route('/cart/delete/{id}', name: 'delete_from_cart')]
    public function delete(CartManager $cart, $id): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }
}
