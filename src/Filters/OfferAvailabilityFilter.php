<?php

namespace App\Filters;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

class OfferAvailabilityFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $offerAlias = $queryBuilder->getRootAliases()[0];

        if ($property === 'startDate') {

            // make SubQuery
            $sqb = $queryBuilder->getEntityManager()->createQueryBuilder();
            $sqb->select('IDENTITY(sr.offer)')
                ->from('App:Reservation', 'sr')
                ->where($sqb->expr()->eq('sr.offer', $offerAlias . '.id'))
                ->andWhere(
                    '
                        (:startDate BETWEEN sr.startDate AND sr.endDate)
                        OR (:endDate BETWEEN sr.startDate AND sr.endDate) 
                        OR (:startDate < sr.startDate AND :endDate > sr.endDate)
                    '
                );
            //dd($sqb->getQuery()->getSQL());
            $queryBuilder->andWhere($queryBuilder->expr()->not($queryBuilder->expr()->exists($sqb->getDQL())))
                ->setParameter('startDate', $value);
        }

        if ($property === 'endDate') {
            $queryBuilder->setParameter('endDate', $value);
        }

        // TODO
        // handle reservation status in condition
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'startDate' => [
                'property' => null,
                'type' => 'date',
                'required' => false,
                'openapi' => [
                    'description' => 'Search available offers starting from startDate',
                ],
            ],
            'endDate' => [
                'property' => null,
                'type' => 'date',
                'required' => false,
                'openapi' => [
                    'description' => 'Search available offers until endDate',
                ],
            ]
        ];
    }
}
