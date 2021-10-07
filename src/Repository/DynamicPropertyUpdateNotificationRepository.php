<?php

namespace App\Repository;

use App\Entity\DynamicPropertyUpdateNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DynamicPropertyUpdateNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method DynamicPropertyUpdateNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method DynamicPropertyUpdateNotification[]    findAll()
 * @method DynamicPropertyUpdateNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DynamicPropertyUpdateNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DynamicPropertyUpdateNotification::class);
    }

    // /**
    //  * @return DynamicPropertyUpdateNotification[] Returns an array of DynamicPropertyUpdateNotification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DynamicPropertyUpdateNotification
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
