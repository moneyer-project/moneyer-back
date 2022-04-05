<?php

namespace App\Repository\Bank\ChargeGroup;

use App\Entity\Bank\ChargeGroup\ExpenseGroup;
use App\Repository\Bank\ChargeRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExpenseGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpenseGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpenseGroup[]    findAll()
 * @method ExpenseGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseGroupRepository extends ChargeRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpenseGroup::class);
    }

    // /**
    //  * @return Expense[] Returns an array of Expense objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Expense
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
