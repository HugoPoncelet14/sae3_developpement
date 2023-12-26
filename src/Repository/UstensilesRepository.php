<?php

namespace App\Repository;

use App\Entity\Ustensiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ustensiles>
 *
 * @method Ustensiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ustensiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ustensiles[]    findAll()
 * @method Ustensiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UstensilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ustensiles::class);
    }

//    /**
//     * @return Ustensiles[] Returns an array of Ustensiles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ustensiles
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
