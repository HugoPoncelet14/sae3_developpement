<?php

namespace App\Repository;

use App\Entity\Recette;
use App\Form\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Recette>
 *
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Recette::class);
        $this->$paginator = $paginator;
    }

    public function search($searchText = ''): array
    {
        $query = $this->createQueryBuilder('q');
        $query->where($query->expr()->orX(
            $query->expr()->like('q.nomRec', ':search'),
        ))
            ->setParameter('search', '%'.$searchText.'%')
            ->orderBy('q.nomRec', 'ASC');
        $res = $query->getQuery();

        return $res->getResult();
    }

    public function recommandation(): array
    {
        $qb = $this->createQueryBuilder('r')
        ->setMaxResults(4);
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function findSearch(SearchData $search): array
    {
        $query = $this->createQueryBuilder('r')
                ->innerJoin('r.pays', 'p')
                ->innerJoin('r.typeRecette', 't');

        if (!empty($search->pays)) {
            $query = $query
                ->andWhere('p.id IN (:pays)')
                ->setParameter('pays', $search->pays);
        }
        if (!empty($search->region)) {
            $query = $query
                ->innerJoin('p.region', 're')
                ->andWhere('re.id IN (:region)')
                ->setParameter('region', $search->region);
        }
        if (!empty($search->typeRecette)) {
            $query = $query
                ->andWhere('t.id IN (:typeRecette)')
                ->setParameter('typeRecette', $search->typeRecette);
        }
        $query = $query->getQuery();

        return $this->paginator->paginate
    }

    //    /**
    //     * @return Recette[] Returns an array of Recette objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Recette
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
