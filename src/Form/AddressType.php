<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom de votre adresse :',
                'attr'=> [
                    'placeholder' => 'Nommez votre adresse'
                ]
            ])
            ->add('firstname',TextType::class,[
                'label' => ' Votre Prenom :',
                'attr'=> [
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label' => ' Votre nom',
                'attr'=> [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('Company',TextType::class,[
                'label' => 'Votre entreprise :',
                'required' => false,
                'attr' => [
                    'placeholder' => '(facultatif) Nom entreprise'
                ]
            ])
            ->add('address',TextType::class,[
                'label' => 'Votre Adresse :',
                'attr' => [
                    'placeholder' => 'Adresse'
                ]
            ])
            ->add('postal',TextType::class,[
                'label' => 'Votre code Postal :',
                'attr' => [
                    'placeholder' => 'Code Postal'
                ]
            ])
            ->add('city',TextType::class,[
                'label' => 'Votre ville :',
                'attr' => [
                    'placeholder' => 'Ville'
                ]
            ])
            ->add('country',CountryType::class,[
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'Votre Pays'
                ]
            ])
            ->add('phone',TelType::class,[
                'label' => 'Votre numéro de téléphone :',
                'attr' => [
                    'placeholder' => 'numéro'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'ajouter mon adresse',
                'attr' =>[
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
