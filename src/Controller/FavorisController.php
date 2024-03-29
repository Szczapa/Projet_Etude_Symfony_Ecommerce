<?php

namespace App\Controller;

use App\Classes\FavorisManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Favoris;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class FavorisController extends AbstractController
{
        private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, FavorisManager $favorisManager)
    {
        $this-> entityManager = $entityManager;
        $this-> favorisManager = $favorisManager;
    }

    // Ajout de favoris
     #[Route('/favori/add/{slug}', name: 'add_to_fav')]
    public function addFavori(string $slug)
    {
        // Récupération du produit de la page
            $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        // Récupération de l'id du produit correspondant au slug
            $idProduct = $product ->getId();
        // Récupération de l'utilisateur de la session active
            $user = $this->getUser();

        // si un url est tapé avec un produit non correspondant -> retour à la page produit
        if (!$product) {
                 return $this->redirectToRoute('product');
        }
        // Si aucun utilisateur connecté on retourne la page actuelle
        if (!$user) {
            return $this->redirectToRoute('product_slug', ['slug' => $slug]);
        }

        // Récupération du Favori de l'utilisateur connecté pour le produit affiché
        $fav = $this->entityManager->getRepository(Favoris::class)->findMyFav($idProduct, $user, 1);

        // Si il n'existe pas de favori et qu'un utilisateur est connecté 
        if (!$fav && $user) {
            $this->favorisManager->addFavori($user,$product);
        }
        // Retour à la page de produit affiché avec la mise à jour du visuel
        return $this->redirectToRoute('product_slug', ['slug' => $slug]);
    }


    // Suppression de favoris
    #[Route('/favori/remove/{slug}', name: 'remove_to_fav')]
    public function removeFavori(string $slug)
    {
        // Récupération du produit de la page
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        // Récupération de l'id du produit correspondant au slug
        $idProduct = $product ->getId();
        // Récupération de l'utilisateur de la session active
        $user = $this->getUser();

        // si un url est tapé avec un produit non correspondant -> retour à la page produit
        if (!$product) {
            return $this->redirectToRoute('product');
        }
        // Si aucun utilisateur connecté on retourne la page actuelle
        if (!$user) {
            return $this->redirectToRoute('product_slug', ['slug' => $slug]);
        }

        // Récupération du Favori de l'utilisateur connecté pour le produit affiché
        $fav = $this->entityManager->getRepository(Favoris::class)->findOneBy(["product" => $idProduct,"user" => $user, "favoris" => 1]);

        // Si il existe un favori et qu'un utilisateur est connecté 
        if ($fav && $user) {
            $this->favorisManager->removeFavori($fav);                   
        }
         // Retour à la page de produit affiché avec la mise à jour du visuel
         return $this->redirectToRoute('product_slug', ['slug' => $slug]);
    }
}
