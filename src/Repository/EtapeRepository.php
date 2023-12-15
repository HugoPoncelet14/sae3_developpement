<?php

namespace App\Repository;

use App\Entity\Etape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etape>
 *
 * @method Etape|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etape|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etape[]    findAll()
 * @method Etape[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtapeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etape::class);
    }

    public function getAllEtapeWithRecetteId(int $id): array
    {
        $qb = $this->createQueryBuilder('e')
            ->innerJoin('e.recette', 'r')
            ->where('r.id = :id')
            ->setParameter(':id', $id)
            ->orderBy('e.numEtape');
        $querry = $qb->getQuery();

        return $querry->getResult();
    }

    //    /**
    //     * @return Etape[] Returns an array of Etape objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Etape
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
