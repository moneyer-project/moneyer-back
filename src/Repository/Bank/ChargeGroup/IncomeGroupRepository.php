<?php

namespace App\Repository\Bank\ChargeGroup;

use App\Entity\Bank\ChargeGroup\IncomeGroup;
use App\Repository\Bank\ChargeRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IncomeGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncomeGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncomeGroup[]    findAll()
 * @method IncomeGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncomeGroupRepository extends ChargeRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IncomeGroup::class);
    }

    // /**
    //  * @return Income[] Returns an array of Income objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Income
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
