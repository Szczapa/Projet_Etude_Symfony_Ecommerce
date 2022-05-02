<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefautController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(SessionInterface $session): Response
    {
        return $this->render('defaut/defaut.html.twig');
    }
}
