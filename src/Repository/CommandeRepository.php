<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function findWithLignesAndArticles(int $id): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.commandeLignes', 'lignes')
            ->addSelect('lignes')
            ->leftJoin('lignes.article', 'article')
            ->addSelect('article')
            ->leftJoin('c.user', 'user')
            ->addSelect('user')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
