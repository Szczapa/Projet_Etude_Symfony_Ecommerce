<?php

namespace App\Controller;

use App\Classes\Favorisfound;
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
    public function product(string $slug, Request $request, Note $note, Favorisfound $findfavori): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $user = $this->getUser();

        if (!$product) {
            return $this->redirectToRoute('products');
        }

        $idProduct = $product ->getId();
        $best = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $favori = $findfavori -> getFavori($idProduct, $user);
        $moyenne = $note -> getFullNote($idProduct);


        // Partie Commentaire du produit
        $commentStatut = null;
        $comments = $this->entityManager->getRepository(Comment::class)->findCommentbyprod($idProduct);
        $com = $this->entityManager->getRepository(Comment::class)->findMyComment($idProduct, $user);

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

        return $this->render(
            'product/show.html.twig',
            [
            'product' => $product,
            'best' => $best,
            'commentStatut' => $commentStatut,
            'comments' => $comments,
            'form' => $form->createView(),
            'favori' => $favori,
            'moyenne' => $moyenne
            ]
        );
    }
}
