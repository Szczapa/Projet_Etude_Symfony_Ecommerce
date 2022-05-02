<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AdressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\ORM\EntityManagerInterface;

class AccountAdressController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }

    #[Route('/compte/adresses', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route('/compte/ajouter-adresses', name: 'account_address_add')]
    public function add(Request $request): Response
    {   
        $address = new Address();
        $form = $this->createForm(AdressType::class,$address);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $address -> setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            return $this->redirectToRoute('account_address');
            
        }
        return $this->render('account/address_add.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
