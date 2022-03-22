<?php

namespace App\Repository\Bank;

use App\Entity\Bank\Account;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function persist(Account $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Account $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Account[] Returns an array of Account objects
     */
    public function findByUser(User $user, ?\DateTime $date = null)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->addSelect(['e', 'i'])
            ->leftJoin('a.user', 'u')
            ->setParameter('user', $user);

        if (null !== $date) {
            $queryBuilder
                ->leftJoin('a.incomes', 'i', Join::WITH, 'MONTH(i.date) = :month AND YEAR(i.date) = :year')
                ->leftJoin('i.distribution', 'id')
                ->leftJoin('a.expenses', 'e', Join::WITH, 'MONTH(e.date) = :month AND YEAR(e.date) = :year')
                ->leftJoin('e.distribution', 'ed')
                ->setParameter('month', $date->format('m'))
                ->setParameter('year', $date->format('Y'));
        } else {
            $queryBuilder
                ->leftJoin('a.incomes', 'i')
                ->leftJoin('i.distribution', 'id')
                ->leftJoin('a.expenses', 'e')
                ->leftJoin('e.distribution', 'ed');
        }

        $orX = $queryBuilder->expr()->orX()
            ->add('u = :user')
            ->add(':user MEMBER OF ed.payers OR :user MEMBER OF id.payers');

        $queryBuilder->andWhere($orX);

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Account
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
