<?php

namespace App\Factory;

use App\Entity\OfferType;
use App\Repository\OfferTypeRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<OfferType>
 *
 * @method static OfferType|Proxy createOne(array $attributes = [])
 * @method static OfferType[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static OfferType|Proxy find(object|array|mixed $criteria)
 * @method static OfferType|Proxy findOrCreate(array $attributes)
 * @method static OfferType|Proxy first(string $sortedField = 'id')
 * @method static OfferType|Proxy last(string $sortedField = 'id')
 * @method static OfferType|Proxy random(array $attributes = [])
 * @method static OfferType|Proxy randomOrCreate(array $attributes = [])
 * @method static OfferType[]|Proxy[] all()
 * @method static OfferType[]|Proxy[] findBy(array $attributes)
 * @method static OfferType[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static OfferType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OfferTypeRepository|RepositoryProxy repository()
 * @method OfferType|Proxy create(array|callable $attributes = [])
 */
final class OfferTypeFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'isTrending' => true
        ];
    }

    protected function initialize(): self
    {
        return $this
        ;
    }

    protected static function getClass(): string
    {
        return OfferType::class;
    }
}
