<?php

namespace App\Repository;

use App\Entity\DynamicProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DynamicProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method DynamicProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method DynamicProperty[]    findAll()
 * @method DynamicProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DynamicPropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DynamicProperty::class);
    }

    // /**
    //  * @return DynamicProperty[] Returns an array of DynamicProperty objects
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
    public function findOneBySomeField($value): ?DynamicProperty
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
