<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'new_password',
                RepeatedType::class,
                [
                'type' => PasswordType::class,
                'invalid_message' => 'Mot de passe erroné',
                'required' => true,

                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'saisir nouveau un mot de passe'
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmer nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Confimer nouveau mot de passe'
                    ],
                ]
                ]
            )

            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Modifier mon mot de passe',
                    'attr' => [
                        'class' => 'btn-block btn-info'
                    ]
                ]
            );

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
