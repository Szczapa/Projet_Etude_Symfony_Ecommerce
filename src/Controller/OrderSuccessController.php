<?php

namespace App\Controller;

use App\Classes\CartManager;
use App\Classes\Mail;
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
    public function index($CHECKOUT_SESSION_ID, CartManager $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['stripeSessionId' =>  $CHECKOUT_SESSION_ID]);
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($order->getState() == 0) {
            $cart->remove();
            $order->setState(1);
            $this->entityManager->flush();

            $mail = new Mail();
            $content = "Bonjour, " . $order->getUser()->getFirstname() . " <br> nous sommes ravies que vous ayez passé commande chez nous ! La commande est désormais en préparation.";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Merci de votre commande', $content);
        }

        return $this->render(
            'order/order_validate.html.twig',
            [
            'order' => $order,
            ]
        );
    }
}
