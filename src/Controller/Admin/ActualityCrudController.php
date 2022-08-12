<?php

namespace App\Controller\Admin;
use DateTimeFieldTrait;
use App\Entity\Actuality;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActualityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actuality::class;
    }


    public function configureFields(string $pageName): iterable
    {
        
        return [
            TextField::new('title', 'titre'),
            TextField::new('subtitle', 'sous-titre'),
            ImageField::new('image')
                ->setUploadDir('public/uploads/')
                ->setBasePath('uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextareaField::new('content', 'contenue'),            
            DateField::new('createdAt')            ,             
            BooleanField::new('post', 'afficher')
        ];
    }
}
