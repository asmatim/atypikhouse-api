<?php

namespace App\Repository;

use App\Entity\OfferUnavailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfferUnavailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferUnavailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferUnavailability[]    findAll()
 * @method OfferUnavailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferUnavailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferUnavailability::class);
    }

    // /**
    //  * @return OfferUnavailability[] Returns an array of OfferUnavailability objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OfferUnavailability
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
