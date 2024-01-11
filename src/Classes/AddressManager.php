<?php

namespace App\Classes;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AddressManager
{
    private $entityManager;
    private $requestStack;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack->getSession();
        $this->entityManager = $entityManager;
    }

    public function addAddress($address,$user)
    {
        $address -> setUser($user);
        $this->entityManager->persist($address);
        $this->entityManager->flush();
    }

    public function editAddress($address)
    {
        $this->entityManager->flush();
    }

    public function removeAddress($address)
    {
        $this->entityManager->remove($address);
        $this->entityManager->flush();
    }

    public function checkAddress($address, $user)
    {
        return $address && $address->getUser() === $user;
    }
    
}
