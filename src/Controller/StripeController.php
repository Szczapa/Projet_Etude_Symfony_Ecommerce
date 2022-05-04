<?php

namespace App\Controller;

use App\Classes\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends AbstractController
{
    #[Route('/commande/craete-session', name: 'stripe_create_session')]
    public function index(Cart $cart) 
    {
        Stripe::setApiKey('sk_test_51KveoEKtLKjmqPB1YKe0w7c9u4iZ76JvLBR1YKTzBaVpVvUTMfrt31B2STcoEeTwx17Z2q3JRtK3wcF9bMDV236T00xjvnrKqE');

        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

            $product_for_stripe = [];

            foreach($cart->getFull() as $product){

                 $product_for_stripe[] = [
                    'price' => $product['product']->getPrix(),
                    'quantity' => $product['quantity'],
                ];
            }
        $checkout_session = Session::create([
        'line_items' => [[
        # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
        $product_for_stripe
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success.html',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);
    }
}
