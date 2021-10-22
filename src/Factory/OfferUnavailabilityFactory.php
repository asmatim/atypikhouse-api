<?php

namespace App\Factory;

use App\Entity\OfferUnavailability;
use App\Repository\OfferUnavailabilityRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<OfferUnavailability>
 *
 * @method static OfferUnavailability|Proxy createOne(array $attributes = [])
 * @method static OfferUnavailability[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static OfferUnavailability|Proxy find(object|array|mixed $criteria)
 * @method static OfferUnavailability|Proxy findOrCreate(array $attributes)
 * @method static OfferUnavailability|Proxy first(string $sortedField = 'id')
 * @method static OfferUnavailability|Proxy last(string $sortedField = 'id')
 * @method static OfferUnavailability|Proxy random(array $attributes = [])
 * @method static OfferUnavailability|Proxy randomOrCreate(array $attributes = [])
 * @method static OfferUnavailability[]|Proxy[] all()
 * @method static OfferUnavailability[]|Proxy[] findBy(array $attributes)
 * @method static OfferUnavailability[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static OfferUnavailability[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OfferUnavailabilityRepository|RepositoryProxy repository()
 * @method OfferUnavailability|Proxy create(array|callable $attributes = [])
 */
final class OfferUnavailabilityFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(OfferUnavailability $offerUnavailability) {})
        ;
    }

    protected static function getClass(): string
    {
        return OfferUnavailability::class;
    }
}
