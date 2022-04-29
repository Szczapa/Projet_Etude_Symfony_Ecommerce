<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }

    #[Route('/compte/mdp', name: 'app_account_password')]
    public function index(Request $request,UserPasswordHasherInterface $hasher)
    {
        $notification = null;
        $notification2 = null;

        $user = $this->getUser();   

        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $old_password = $form->get('old_password')->getData();

            if($hasher->isPasswordValid($user, $old_password)){
                $new_pwd = $form->get('new_password')->getData();

            $password = $hasher->hashPassword(
                $user,
                $new_pwd
            );
            $user->setPassword($password);
            
            $this->entityManager->flush();
            $notification = 'votre mot de passe est modifié';
            }else{
                $notification2 = 'Erreur dans le mot de passe';
            }
        }

        return $this->renderForm('account/password.html.twig',[
            'form' => $form,
            'notification' => $notification,
            'notification2' => $notification2
        ]);
    }
}
