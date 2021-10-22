<?php

namespace App\Factory;

use App\Entity\DayUnavailability;
use App\Repository\DayUnavailabilityRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<DayUnavailability>
 *
 * @method static DayUnavailability|Proxy createOne(array $attributes = [])
 * @method static DayUnavailability[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static DayUnavailability|Proxy find(object|array|mixed $criteria)
 * @method static DayUnavailability|Proxy findOrCreate(array $attributes)
 * @method static DayUnavailability|Proxy first(string $sortedField = 'id')
 * @method static DayUnavailability|Proxy last(string $sortedField = 'id')
 * @method static DayUnavailability|Proxy random(array $attributes = [])
 * @method static DayUnavailability|Proxy randomOrCreate(array $attributes = [])
 * @method static DayUnavailability[]|Proxy[] all()
 * @method static DayUnavailability[]|Proxy[] findBy(array $attributes)
 * @method static DayUnavailability[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static DayUnavailability[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static DayUnavailabilityRepository|RepositoryProxy repository()
 * @method DayUnavailability|Proxy create(array|callable $attributes = [])
 */
final class DayUnavailabilityFactory extends ModelFactory
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
            'value' => null, // TODO add APP\ENUM\DAYOFWEEK ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(DayUnavailability $dayUnavailability) {})
        ;
    }

    protected static function getClass(): string
    {
        return DayUnavailability::class;
    }
}
