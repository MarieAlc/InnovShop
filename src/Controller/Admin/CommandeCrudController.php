<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
      $fields = [];

    if ($pageName === 'index'|| $pageName === 'detail') {
        $fields[] = IdField::new('id');
        $fields[] = TextField::new('user.nom', 'Nom');
        $fields[] = TextField::new('user.prenom', 'Prénom');
        $fields[] = TextField::new('adresseComplete', 'Adresse de livraison');
        $fields[] = TextField::new('user.email', 'Mail');
        $fields[] = TextField::new('articlesList', 'Articles');
        
    }

        $fields[] = ChoiceField::new('status')
            ->setChoices([
                'En attente' => 'en_attente',
                'Expédiée' => 'expediee',
                'Livrée' => 'livree',
                'Annulée' => 'annulee',
            ])
            ->renderAsBadges([
                'en_attente' => 'warning',
                'expediee' => 'info',
                'livree' => 'success',
                'annulee' => 'danger',
            ]);

        $fields[] = DateTimeField::new('createdAt')->hideOnForm();

    return $fields;
    }
    public function configureActions(Actions $actions): Actions{
        return $actions
        ->add ( 'index', Action::DETAIL);
    }

    
}
