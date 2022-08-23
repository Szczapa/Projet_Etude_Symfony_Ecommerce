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

    // Récupération et Set de la Valeur de la Variables $favoris
    function getFavori($idProduct, $user)
    {
        // Requête de la variables $fav -> Trouver 1 objet avec les crytères : Utilisateur connecté / Produit affiché actuellement / Favoris = true
        $fav = $this->entityManager->getRepository(Favoris::class)->findOneBy(["product" => $idProduct,"user" => $user, "favoris" => 1]);

        // Valeur par défaut de Favori
        $favori = false;

        // Si il y a un bien objet dans $fav 
        if ($fav) {
        // Favori = true
            $favori = true;
        }
        // Retour de la valeur favori pour l'affichage
        return $favori;
    }
}
