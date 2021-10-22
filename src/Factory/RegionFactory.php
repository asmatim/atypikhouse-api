<?php

namespace App\Factory;

use App\Entity\Region;
use App\Repository\RegionRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Region>
 *
 * @method static Region|Proxy createOne(array $attributes = [])
 * @method static Region[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Region|Proxy find(object|array|mixed $criteria)
 * @method static Region|Proxy findOrCreate(array $attributes)
 * @method static Region|Proxy first(string $sortedField = 'id')
 * @method static Region|Proxy last(string $sortedField = 'id')
 * @method static Region|Proxy random(array $attributes = [])
 * @method static Region|Proxy randomOrCreate(array $attributes = [])
 * @method static Region[]|Proxy[] all()
 * @method static Region[]|Proxy[] findBy(array $attributes)
 * @method static Region[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Region[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RegionRepository|RepositoryProxy repository()
 * @method Region|Proxy create(array|callable $attributes = [])
 */
final class RegionFactory extends ModelFactory
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
            'name' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Region $region) {})
        ;
    }

    protected static function getClass(): string
    {
        return Region::class;
    }
}
