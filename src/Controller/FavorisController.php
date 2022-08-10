<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Favoris;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class FavorisController extends AbstractController
{
        private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }

     #[Route('/favori/add/{slug}', name: 'add_to_fav')]
    public function addFavori(string $slug)
    {
            $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
            $user = $this->getUser();
            $idProduct = $product ->getId();

        if (!$product) {
                 return $this->redirectToRoute('product');
        }

        if (!$user) {
            return $this->redirectToRoute('product_slug', ['slug' => $slug]);
        }

        $fav = $this->entityManager->getRepository(Favoris::class)->findMyFav($idProduct, $user, 1);

        if (!$fav && $user) {
            $favoris = new Favoris();
            $favoris ->setUser($user);
            $favoris->SetProduct($product);
            $favoris->setFavoris(1);
            $this->entityManager->persist($favoris);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('product_slug', ['slug' => $slug]);
    }

    #[Route('/favori/remove/{slug}', name: 'remove_to_fav')]
    public function removeFavori(string $slug)
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $user = $this->getUser();
        $idProduct = $product ->getId();

        if (!$product) {
            return $this->redirectToRoute('product');
        }

        if (!$user) {
            return $this->redirectToRoute('product_slug', ['slug' => $slug]);
        }

        $fav = $this->entityManager->getRepository(Favoris::class)->findOneBy(["product" => $idProduct,"user" => $user, "favoris" => 1]);

        if ($fav && $user) {
            $this->entityManager->remove($fav);
            $this->entityManager->flush();
            return $this->redirectToRoute('product_slug', ['slug' => $slug]);
        }
         return $this->redirectToRoute('product_slug', ['slug' => $slug]);
    }
}
