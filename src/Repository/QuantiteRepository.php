<?php

namespace App\Repository;

use App\Entity\Quantite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quantite>
 *
 * @method Quantite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quantite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quantite[]    findAll()
 * @method Quantite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuantiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quantite::class);
    }

    public function AllQuantiteByRecetteId(int $idRec): array
    {
        $qb = $this->createQueryBuilder('q')
            ->innerJoin('q.ingredient', 'i')
            ->innerJoin('q.recette', 'r')
            ->addSelect('i as ingredient')
            ->where('r.id = :id')
            ->setParameter(':id', $idRec);
        $query = $qb->getQuery();

        return $query->getResult();
    }
    //    /**
    //     * @return Quantite[] Returns an array of Quantite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Quantite
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
