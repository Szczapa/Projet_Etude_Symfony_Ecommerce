<?php

namespace App\Controller;

use App\Entity\Actuality;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualityController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/actuality', name: 'actuality')]
    public function index(): Response
    {
        $posts =  $this->entityManager->getRepository(Actuality::class)->findByPost(1);

        return $this->render('actuality/actuality.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/actuality/{id}', name: 'actuality_show')]
    public function show($id): Response
    {
        $post = $this->entityManager->getRepository(Actuality::class)->findOneBy(['id' => $id]);
        return $this->render('actuality/actuality_show.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('/admin/actuality/check', name: 'actuality_check')]
    public function actucheck(): Response
    {
       return $this->render('actuality/actuality_check.html.twig', [
           
        ]);      
    }

    #[Route('/admin/actuality/add', name: 'actuality_add')]
    public function createactu()
    {

    }

    #[Route('/actuality/remove', name: 'actuality_remove')]
    public function removeactu()
    {
       
        
    }
}
