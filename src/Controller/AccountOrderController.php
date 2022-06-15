<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/mes-commandes', name: 'account_orders')]
    public function index(): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccesOrders($this->getUser());

        return $this->render(
            'account/account_orders.html.twig', [
            'orders' => $orders
            ]
        );
    }

    #[Route('/compte/mes-commande/{reference}', name: 'account_order')]
    public function details($reference): Response
    {
        
         $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);
         
        if(!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_orders');
        }
        return $this->render(
            'account/account_order.html.twig', [
            'order' => $order
            ]
        );
    }
}
