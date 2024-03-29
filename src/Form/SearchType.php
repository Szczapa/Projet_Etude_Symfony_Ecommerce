<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Classes\Search;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'string',
                TextType::class,
                [
                'label' => false,
                'required' => false,
                'attr' => [
                'placeholder' => 'Rechercher',
                'class' => 'form-control-sm'
                ]
                ]
            )

            ->add(
                'categories',
                EntityType::class,
                [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' =>  true
                ]
            )

            -> add(
                'submit',
                SubmitType::class,
                [
                'label' => 'Appliquer',
                'attr' => [
                'class' => 'btn-block btn-info'
                ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protextion' => false,
            ]
        );
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
