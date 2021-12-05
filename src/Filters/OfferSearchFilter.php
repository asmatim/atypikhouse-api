<?php

namespace App\Filters;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

class OfferSearchFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if ($property !== 'search') {
            return;
        }
        $alias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->join($alias . '.address', 'ad')
            ->join('ad.city', 'ct')
            ->join('ct.region', 'reg')
            ->join('reg.country', 'cn')
            ->andWhere(sprintf('%s.title LIKE :search OR ct.name LIKE :search OR cn.name LIKE :search', $alias))
            ->setParameter('search', '%' . $value . '%');
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'search' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'Search across multiple fields',
                ],
            ]
        ];
    }
}
