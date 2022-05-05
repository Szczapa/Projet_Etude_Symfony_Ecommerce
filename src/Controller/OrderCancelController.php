<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OrderCancelController extends AbstractController
{  
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/cancel/{CHECKOUT_SESSION_ID}', name: 'order_cancel')]
    public function index($CHECKOUT_SESSION_ID): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['stripeSessionId' =>  $CHECKOUT_SESSION_ID]);

        if(!$order || $order->getUser() != $this->getUser())
        {
            return $this->redirectToRoute('home');
        }

        return $this->render('order/order_cancel.html.twig',[
            'order' => $order
        ]);
    }
}
