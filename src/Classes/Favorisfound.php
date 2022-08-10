<?php

namespace App\Classes;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Favoris;

class Favorisfound
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }

    function getFavori($idProduct, $user)
    {
        $fav = $this->entityManager->getRepository(Favoris::class)->findOneBy(["product" => $idProduct,"user" => $user, "favoris" => 1]);

        $favori = false;

        if ($fav) {
            $favori = true;
        }
        return $favori;
    }
}
