<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticlesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextField::new('detail'),
            Textfield::new('specification'),
            ImageField::new('image')
                ->setBasePath('uploads/articles')
                ->setUploadDir('public/uploads/articles')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            BooleanField::new('aLaUne', 'Mettre à la une'),

            AssociationField::new('couleurs')
            ->setFormTypeOptions([
                'by_reference' => false,
            ])
            ->setHelp('Sélectionne une ou plusieurs couleurs pour cet article'),

            AssociationField::new('tailles')
            ->setFormTypeOptions([
                'by_reference' => false,
                ])
                ->setHelp('Sélectionne les tailles disponibles pour cet article'),

             AssociationField::new('type')
            ->setHelp('Sélectionne le type pour cet article'),

            ];

    }

}
