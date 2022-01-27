<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Enum\ReservationStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */

    public function findByOfferAndClient($offer, $client)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.offer = :offer')
            ->andWhere('r.client = :client')
            ->setParameter('offer', $offer)
            ->setParameter('client', $client)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findCollindingReservations($currentReservationId, $startDate, $endDate, $offer)
    {
        return $this->createQueryBuilder('r')
            ->where('(r.offer = :offer) 
                    AND
                        (
                            (:startDate BETWEEN r.startDate AND r.endDate) 
                            OR (:endDate BETWEEN r.startDate AND r.endDate) 
                            OR (:startDate < r.startDate AND :endDate > r.endDate)
                        )
                    AND r.status != :statusPending 
                    AND r.status != :statusCanceled 
                    AND r.id != :currentReservationId    
                    ')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('offer', $offer)
            ->setParameter('statusPending', ReservationStatus::PENDING())
            ->setParameter('statusCanceled', ReservationStatus::CANCELED())
            ->setParameter('currentReservationId', $currentReservationId)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
