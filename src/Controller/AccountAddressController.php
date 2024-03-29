<?php

namespace App\Controller;

use App\Classes\CartManager;
use App\Classes\AddressManager;
use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
    use Doctrine\ORM\EntityManagerInterface;

class AccountAddressController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, AddressManager $addressClass)
    {
        $this-> entityManager = $entityManager;
        $this-> addressClass = $addressClass;
    }

    #[Route('/compte/adresses', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route('/compte/ajouter-adresses', name: 'account_address_add')]
    public function add(CartManager $cart, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $this->addressClass->addAddress($address,$user);
            if ($cart->get()) {
                return $this->redirectToRoute('order');
            }
            return $this->redirectToRoute('account_address');
        }
        return $this->render(
            'account/address_add.html.twig',
            [
            'form' => $form->createView()
            ]
        );
    }

    #[Route('/compte/edit-adresses/{id}', name: 'account_address_edit')]
    public function edit(Request $request, $id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneBy(['id' => $id]);

        if(!$this->addressClass->checkAddress($address,$this->getUser())){
            return $this->redirectToRoute('account_address');
        }

        // if (!$address || $address->getUser() != $this->getUser()) {
        //     return $this->redirectToRoute('account_address');
        // }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addressClass->editAddress($address);            
            return $this->redirectToRoute('account_address');
        }
        return $this->render(
            'account/address_edit.html.twig',
            [
            'form' => $form->createView()
            ]
        );
    }


    #[Route('/compte/delete-adresses/{id}', name: 'account_address_delete')]
    public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneBy(['id' => $id]);

        if ($address && $address->getUser() == $this->getUser()) {
            $this->addressClass->removeAddress($address);            
        }

        return $this->redirectToRoute('account_address');
    }
}
