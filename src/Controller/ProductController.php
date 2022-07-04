<?php

namespace App\Controller;
use App\Classes\Search;
use App\Entity\Comment;
use App\Entity\Favoris;
use App\Entity\Product;
use App\Form\CommentType;
use App\Form\SearchType as FormSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }

    #[Route('/produits', name: 'products')]
    public function index(Request $request): Response
    {

        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $search = new Search();
        $form = $this->createForm(FormSearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }

        return $this->render(
            'product/product.html.twig',
            [
            'products' => $products,
            'form' => $form->createView()
            ]
        );
    }

    #[Route('/produits/{slug}', name: 'product_slug')]
    public function product(string $slug, Request $request): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $best = $this->entityManager->getRepository(Product::class)->findByIsBest(1);

        if (!$product) {
            return $this->redirectToRoute('products');
        }
        
        $idProduct = $product ->getId();


        // Partie Commentaire du produit 
        $commentStatut = null;

        $comments = $this->entityManager->getRepository(Comment::class)->findByProduct($idProduct);
        $user = $this->getUser();    
        $com = $this->entityManager->getRepository(Comment::class)->findMyComment($idProduct,$user);        
        
        $create = new Comment();
        $form = $this -> createForm(CommentType::class, $create);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $create = $form->getData();

            $create->setUser($user);
            $create->setProduct($product);

            if ($form->isValid()) {
                $this->entityManager->persist($create);
                $this->entityManager->flush();
                return $this->redirect($request->getUri());
            }
            //alerte une erreur est subvenue
        }
        if ($user && $com) {
             $commentStatut = 2;
        } elseif ($user && !$com) {
             $commentStatut = 1;
        } else {
            $commentStatut = 0;
        }

        $favori = false;
        $fav = $this->entityManager->getRepository(Favoris::class)->findMyFav($idProduct,$user,1) ;
        if($fav){
            $favori = true;
        }

        return $this->render(
            'product/show.html.twig',
            [
            'product' => $product,
            'best' => $best,
            'commentStatut' => $commentStatut,
            'comments' => $comments,
            'form' => $form->createView(), 
            'favori'=>$favori,           
            ]
        );
    }

    #[Route('/favori/add/{slug}', name: 'add_to_fav')]
    public function favoris(string $slug) 
    {  
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $user = $this->getUser();
        $idProduct = $product ->getId();

        if (!$product){
            return $this->redirectToRoute('product');
        }

        if (!$user) {
           return $this->redirectToRoute('product_slug',['slug' => $slug]);
           //erreur veuillez vous connecter
        }

        $fav = $this->entityManager->getRepository(Favoris::class)->findMyFav($idProduct,$user,1);

        if(!$fav && $user){
            $favoris = new Favoris();
            $favoris ->setUser($user);
            $favoris->SetProduct($product);
            $favoris->setFavoris(1);
            $this->entityManager->persist($favoris);
            $this->entityManager->flush();    
            
        }       
      return $this->redirectToRoute('product_slug',['slug' => $slug]);
    }

    #[Route('/favori/remove/{slug}', name: 'remove_to_fav')]
    public function favori(string $slug)
    {  

        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $user = $this->getUser();
        $idProduct = $product ->getId();

        if (!$product){
            return $this->redirectToRoute('product');
        }

        if (!$user) {
           return $this->redirectToRoute('product_slug',['slug' => $slug]);
           //erreur veuillez vous connecter
        }

        $fav = $this->entityManager->getRepository(Favoris::class)->findOneBy(["product" => $idProduct,"user" => $user, "favoris" =>1] );

        if($fav && $user){            
            $fav ->setUser($user);
            $fav->SetProduct($product);
            $fav->setFavoris(0);            
            $this->entityManager->flush();            
        return $this->redirectToRoute('product_slug',['slug' => $slug]);
        }
      
    }
}
