<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'register')]
    public function index(Request $request,UserPasswordHasherInterface $hasher): Response
    {   
        $notification = null;        

        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()) {
            
            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneBy([ "email" => $user->getEmail()]);

            if($search_email) {
                $notification = 'Cette Adresse Mail est déjà utilisé';
            } else {
                
                $password = $user->getPassword();

                $passwordHash = $hasher->hashPassword(
                    $user,
                    $password
                );
            
                $user->setPassword($passwordHash);

                $this->entityManager->persist($user);

                $this->entityManager->flush(); 

                $notification = 'Votre inscription à était prise en compte'; 
                
                $mail = new Mail();
                $content = "Bonjour, ".$user->getFirstname()." <br> nous sommes ravies de vous avoir sur notre projet de boutique.";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur notre boutique', $content);
            }            
        }

        return $this->renderForm(
            'register/register.html.twig', [
            'form' => $form,
            'notification' => $notification
            ]
        );
    }
}
