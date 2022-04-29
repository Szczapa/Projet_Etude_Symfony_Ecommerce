<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,
            [
                'disabled' => true,
                'label' => 'Mon email'
            ])
            ->add ('old_password',PasswordType::class,
            [
                'mapped' => false,
                'label'=> 'Mot de passe Actuel',
                'attr'=>[
                    'placeholder'=>'Entrez votre mot de passe actuel'
                ]
            ])
            
            ->add('new_password',RepeatedType::class,
            [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message'=>'Mot de passe erroné',
                'required'=>true,

                'first_options' =>[
                    'label'=> 'Nouveau mot de passe',
                    'attr' => [
                        'placeholder'=>'saisir nouveau un mot de passe'                        
                    ],
                ],
                'second_options'=>[
                    'label'=> 'Confirmer nouveau mot de passe',
                    'attr' => [
                        'placeholder'=>'Confimer nouveau mot de passe'                        
                    ],
                ]
            ])

            ->add('firstname',TextType::class,
            [
                'disabled' => true,
                'label' => 'Mon prenom'
            ])
            ->add('lastname',TextType::class,
            [
                'disabled' => true,
                'label' => 'Mon nom'
            ])

            ->add('submit',SubmitType::class,
                [
                    'label'=>'Modifier'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
