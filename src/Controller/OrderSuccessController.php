<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/success/{CHECKOUT_SESSION_ID}', name: 'order_validate')]
    public function index($CHECKOUT_SESSION_ID,Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['stripeSessionId' =>  $CHECKOUT_SESSION_ID]);
        if(!$order || $order->getUser() != $this->getUser())
        {
            return $this->redirectToRoute('home');
        }

        if(!$order->getIsPaid()){
            $cart->remove();
            $order->setIsPaid(1);
            $this->entityManager->flush();
        }        

        return $this->render('order/order_validate.html.twig',[
            'order' => $order,
        ]);
    }
}
