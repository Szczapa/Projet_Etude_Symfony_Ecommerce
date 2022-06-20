<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/mot-de-passe-oublie', name: 'reset_password')]
    public function index(Request $request): Response
    {


        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')) {
                $User = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            if ($User) {
                $reset_password = new ResetPassword();
                $reset_password->setUser($User);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new DateTime());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                $url = $this->generateUrl('update_password', [ "token" => $reset_password->getToken()]);

                $mail = new Mail();
                $content = "Bonjour, " . $User->getFirstname() . " <br> Vous venez de faire une demande de reset de mot de passe <br>";
                $content .= "<a href ='" . $url . "'> cliquez ici pour le modifier</a>                 
                 <br> Si cette demande ne vient pas de vous veuillez vous connecter et changer de mot de passe";
                $mail->send($User->getEmail(), $User->getFirstname(), 'Reset de mot de passe', $content);
                $this->addFlash('notice', 'Email de récupération envoyé');
            } else {
                $this->addFlash('notice', 'Email inconnu dans la base de donnée utilisateur');
            }
        }
        return $this->render('reset_password/reset_password.html.twig');
    }

        #[Route('/modifier-mon-mot-de-passe/{token}', name: 'update_password')]
    public function update($token, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToker($token);

        if (!$reset_password) {
            return $this->redirectToRoute('reset_password');
        }

        $now = new DateTime();

        if ($now > $reset_password->getCreatedAt()->modify('+3 hour')) {
            $this->addFlash('notice', 'Votre demande à expiré. Merci de la renouveller');
            return $this->redirectToRoute('reset_password');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_pwd = $form->get('new_password')->getData();
            $password = $hasher->hashPassword(
                $reset_password->getUser(),
                $new_pwd
            );
            $reset_password->getUser()->setPassword($password);
            $this->entityManager->flush();
            $this->addFlash('notice', 'Mot de passe mis à jour');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('reset_password/update_password.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
