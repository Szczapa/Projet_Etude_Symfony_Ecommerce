<?php

namespace App\Controller;

use App\Classes\CartManager;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index(CartManager $cart, $reference, EntityManagerInterface $entityManager): Response
    {
        Stripe::setApiKey('');
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

            $product_for_stripe = [];

            $order = $entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);

        if (!$order) {
            return $this->redirectToRoute('/commande/error');
        }

        foreach ($order->getOrderDetails()->getValues() as $product) {
            $product_object = $entityManager->getRepository(Product::class)->findOneBy(['name' => $product -> getProduct()]);

            $product_for_stripe[] = [
            'price_data' => [
                'currency' => 'EUR',
                'product_data' => [
                    'name' => $product->getProduct(),
                    'images' => [$YOUR_DOMAIN . "/uploads/" . $product_object->getImage()],
                ],
                'unit_amount' => $product->getPrice(),
            ],
            'quantity' => $product->getQuantity(),
            ];
        }
            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'EUR',
                    'product_data' => [
                        'name' => $order->getCarrierName()
                    ],
                    'unit_amount' => $order->getCarrierPrice(),
                ],
                'quantity' => 1,
                ];


            $checkout_session = Session::create(
                [
                'customer_email' => $this->getUser()->getEmail(),
                'line_items' => [[
                $product_for_stripe
                ]],

                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/commande/success/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $YOUR_DOMAIN . '/commande/cancel/{CHECKOUT_SESSION_ID}',
                ]
            );
        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $url =  $checkout_session->url;
        return $this->redirect($url);
    }
}
