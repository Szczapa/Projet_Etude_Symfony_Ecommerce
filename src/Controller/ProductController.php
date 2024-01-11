<?php

namespace App\Controller;

use App\Classes\FavorisManager;
use App\Classes\Search;
use App\Classes\Note;
use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Form\SearchType as FormSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    
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
    public function product(string $slug, Request $request, Note $note, FavorisManager $findfavori): Response
    {
        // Récupération du produit de la page
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        // Récupération de l'id du produit correspondant au slug
        $idProduct = $product ->getId();

        // si un url est tapé avec un produit non correspondant -> retour à la page produit
        if (!$product) {
            return $this->redirectToRoute('products');
        }

        // Récupération de l'utilisateur de la session active
        $user = $this->getUser();

        // Si aucun utilisateur connecté on retourne la page actuelle
        $best = $this->entityManager->getRepository(Product::class)->findByIsBest(1);

        // Appelle de la classe FavorisManager et attente du retour de la valeur de favori
        $favori = $findfavori -> getFavori($idProduct, $user);

        // Système de calcul de Moyenne
        $moyenne = $note -> getFullNote($idProduct);

        // Partie Commentaire du produit
        $commentStatut = null;
        
        // Requête Customisé pour trouver les commentaires
        $comments = $this->entityManager->getRepository(Comment::class)->findCommentbyprod($idProduct);
        $com = $this->entityManager->getRepository(Comment::class)->findMyComment($idProduct, $user);

        // Création de Commentaire
        $create = new Comment();
        
        // Récupération du formulaire de Commentaire
        $form = $this -> createForm(CommentType::class, $create);
        $form->handleRequest($request);

        // Si le formulaire est soumis
        if ($form->isSubmitted()) {

            // On récupére les données de la création de commentaire
            $create = $form->getData();

            // On set User sur l'utilisateur actuel
            $create->setUser($user);
            // On set product sur le produit de la page
            $create->setProduct($product);

            // On vérifie si le formulaire est valide
            if ($form->isValid()) {

                // On persiste les information
                $this->entityManager->persist($create);

                // On push en base de données
                $this->entityManager->flush();

                // On redirige sur l'url actuelle
                return $this->redirect($request->getUri());
            }           
        }

        // Selection du statut de commentaire

        // Utilisateur connecté et commentaire existant
        if ($user && $com) {
             $commentStatut = 2;
        }
        // Utilisateur connecté et aucun commentaire
        elseif ($user && !$com) {
             $commentStatut = 1;
        }
        // pas d'utilisteur 
        else {
            $commentStatut = 0;
        }

        //Système de retour / rendu visuel
        return $this->render(
            'product/show.html.twig',
            [
            'product' => $product,
            'best' => $best,
            'commentStatut' => $commentStatut,
            'comments' => $comments,

            // Retour du formulaire et création du visuel
            'form' => $form->createView(),
            // Retour de la valeur de favori
            'favori' => $favori,
            // Retour de la moyenne
            'moyenne' => $moyenne
            ]
        );
    }
}
