<?php

namespace App\Repository\Bank;

use App\Entity\Bank\PaymentDistribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentDistribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentDistribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentDistribution[]    findAll()
 * @method PaymentDistribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentDistributionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentDistribution::class);
    }

    // /**
    //  * @return PaymentDistribution[] Returns an array of PaymentDistribution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PaymentDistribution
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
