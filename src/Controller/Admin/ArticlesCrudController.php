<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use App\Entity\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

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
            TextField::new('specification'),
            TextField::new('prix'),
            ImageField::new('image')
                ->setBasePath('uploads/articles')
                ->setUploadDir('public/uploads/articles')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            BooleanField::new('aLaUne', 'Mettre à la une'),

            AssociationField::new('couleurs')
                ->setFormTypeOption('choice_label', 'valeur')
                ->setFormTypeOptions([
                    'by_reference' => false,])
                ->formatValue(function ($value, $entity) {
                    return implode(', ', $entity->getCouleurs()->map(fn($c) => $c->getValeur())->toArray());
            })
            
            ->setHelp('Sélectionne une ou plusieurs couleurs pour cet article'),

            AssociationField::new('tailles')
                ->setFormTypeOption('choice_label', 'valeur')
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->setHelp('Sélectionne les tailles disponibles pour cet article')
                ->formatValue(function ($value, $entity) {
                    return implode(', ', $entity->getTailles()->map(fn($t) => $t->getValeur())->toArray());
                }),

             AssociationField::new('type')                
                ->setHelp('Sélectionne le type pour cet article')
            

            ];

    }
      public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add('index', Action::DETAIL);
    }
      public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

    return $qb
        ->leftJoin('entity.couleurs', 'c')
        ->addSelect('c')
        ->leftJoin('entity.tailles', 't')
        ->addSelect('t')
        ->leftJoin('entity.type', 'ty')
        ->addSelect('ty');
}



}
