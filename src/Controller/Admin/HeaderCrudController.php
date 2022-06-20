<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
           TextField::new('title', 'Titre du Header'),
           TextareaField::new('content', 'Contenue du Header'),
           TextField::new('btnTitle', 'Titre du btn'),
           TextField::new('btnUrl', 'Url déstination du btn'),
           ImageField::new('image')
               ->setUploadDir('public/uploads/')
               ->setBasePath('uploads/')
               ->setUploadedFileNamePattern('[randomhash].[extension]'),
        ];
    }
}
