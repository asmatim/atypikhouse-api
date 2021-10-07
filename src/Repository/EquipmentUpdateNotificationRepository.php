<?php

namespace App\Repository;

use App\Entity\EquipmentUpdateNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EquipmentUpdateNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipmentUpdateNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipmentUpdateNotification[]    findAll()
 * @method EquipmentUpdateNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentUpdateNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentUpdateNotification::class);
    }

    // /**
    //  * @return EquipmentUpdateNotification[] Returns an array of EquipmentUpdateNotification objects
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
    public function findOneBySomeField($value): ?EquipmentUpdateNotification
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
