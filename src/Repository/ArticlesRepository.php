<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Articles>
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }
    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.couleurs', 'c')->addSelect('c')
            ->leftJoin('a.tailles', 't')->addSelect('t')
            ->leftJoin('a.type', 'ty')->addSelect('ty')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
