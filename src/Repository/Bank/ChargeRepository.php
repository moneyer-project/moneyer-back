<?php

namespace App\Repository\Bank;

use App\Entity\Bank\Account;
use App\Entity\Bank\Charge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Charge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Charge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Charge[]    findAll()
 * @method Charge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass = Charge::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function findInMonth(Account $account, \DateTime $date)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.account = :account')
            ->andWhere('c.date = :date')
            ->setParameter('account', $account)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Charge
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
