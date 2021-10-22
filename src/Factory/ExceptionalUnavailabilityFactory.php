<?php

namespace App\Factory;

use App\Entity\ExceptionalUnavailability;
use App\Repository\ExceptionalUnavailabilityRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<ExceptionalUnavailability>
 *
 * @method static ExceptionalUnavailability|Proxy createOne(array $attributes = [])
 * @method static ExceptionalUnavailability[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static ExceptionalUnavailability|Proxy find(object|array|mixed $criteria)
 * @method static ExceptionalUnavailability|Proxy findOrCreate(array $attributes)
 * @method static ExceptionalUnavailability|Proxy first(string $sortedField = 'id')
 * @method static ExceptionalUnavailability|Proxy last(string $sortedField = 'id')
 * @method static ExceptionalUnavailability|Proxy random(array $attributes = [])
 * @method static ExceptionalUnavailability|Proxy randomOrCreate(array $attributes = [])
 * @method static ExceptionalUnavailability[]|Proxy[] all()
 * @method static ExceptionalUnavailability[]|Proxy[] findBy(array $attributes)
 * @method static ExceptionalUnavailability[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static ExceptionalUnavailability[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ExceptionalUnavailabilityRepository|RepositoryProxy repository()
 * @method ExceptionalUnavailability|Proxy create(array|callable $attributes = [])
 */
final class ExceptionalUnavailabilityFactory extends ModelFactory
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
            'startDate' => self::faker()->datetime(),
            'endDate' => self::faker()->datetime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(ExceptionalUnavailability $exceptionalUnavailability) {})
        ;
    }

    protected static function getClass(): string
    {
        return ExceptionalUnavailability::class;
    }
}
