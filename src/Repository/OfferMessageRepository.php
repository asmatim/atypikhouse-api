<?php

namespace App\Repository;

use App\Entity\OfferMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfferMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferMessage[]    findAll()
 * @method OfferMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferMessage::class);
    }

    // /**
    //  * @return OfferMessage[] Returns an array of OfferMessage objects
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
    public function findOneBySomeField($value): ?OfferMessage
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
