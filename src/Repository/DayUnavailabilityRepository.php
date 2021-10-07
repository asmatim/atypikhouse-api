<?php

namespace App\Repository;

use App\Entity\DayUnavailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DayUnavailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method DayUnavailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method DayUnavailability[]    findAll()
 * @method DayUnavailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DayUnavailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DayUnavailability::class);
    }

    // /**
    //  * @return DayUnavailability[] Returns an array of DayUnavailability objects
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
    public function findOneBySomeField($value): ?DayUnavailability
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
