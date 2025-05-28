<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use Doctrine\DBAL\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;

use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;


class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [];

        if ($pageName === 'index' || $pageName === 'detail') {
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
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add('index', Action::DETAIL);
    }

    public function createIndexQueryBuilder( SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters) : QueryBuilder {    
        return $this->em
            ->getRepository(Commande::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.commandeLignes', 'lignes')
            ->addSelect('lignes')
            ->leftJoin('lignes.article', 'article')
            ->addSelect('article')
            ->leftJoin('c.user', 'user')
            ->addSelect('user');
    }

    public function createDetailQueryBuilder(SearchDto $searchDto,EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder 
    {
        $id = $searchDto->getQuery();

        return $this->em
            ->getRepository(Commande::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.commandeLignes', 'lignes')->addSelect('lignes')
            ->leftJoin('lignes.article', 'article')->addSelect('article')
            ->leftJoin('c.user', 'user')->addSelect('user')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id);
    }
}



