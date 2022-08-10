<?php

namespace App\Classes;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Note
{
    private $entityManager;
    private $requestStack;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack->getSession();
        $this-> entityManager = $entityManager;
    }




    public function getFullNote($idProduct)
    {
        $NoteContent = [];
        $notes = $this->entityManager->getRepository(Comment::class)->findByProduct($idProduct);
        // dd($notes);

        if (!$notes) {
            $nonot = null;
            return $nonot;
        }

        foreach ($notes as $note) {
            $NoteContent[] =  $note->getNote();
        }

        $moyenne = array_sum($NoteContent) / count($NoteContent);

        return $moyenne;
    }
}
