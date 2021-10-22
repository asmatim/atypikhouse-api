<?php

namespace App\Factory;

use App\Entity\DynamicProperty;
use App\Repository\DynamicPropertyRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<DynamicProperty>
 *
 * @method static DynamicProperty|Proxy createOne(array $attributes = [])
 * @method static DynamicProperty[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static DynamicProperty|Proxy find(object|array|mixed $criteria)
 * @method static DynamicProperty|Proxy findOrCreate(array $attributes)
 * @method static DynamicProperty|Proxy first(string $sortedField = 'id')
 * @method static DynamicProperty|Proxy last(string $sortedField = 'id')
 * @method static DynamicProperty|Proxy random(array $attributes = [])
 * @method static DynamicProperty|Proxy randomOrCreate(array $attributes = [])
 * @method static DynamicProperty[]|Proxy[] all()
 * @method static DynamicProperty[]|Proxy[] findBy(array $attributes)
 * @method static DynamicProperty[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static DynamicProperty[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static DynamicPropertyRepository|RepositoryProxy repository()
 * @method DynamicProperty|Proxy create(array|callable $attributes = [])
 */
final class DynamicPropertyFactory extends ModelFactory
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
            'isMandatory' => self::faker()->boolean(),
            'type' => null, // TODO add APP\ENUM\DYNAMICPROPERTYTYPE ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(DynamicProperty $dynamicProperty) {})
        ;
    }

    protected static function getClass(): string
    {
        return DynamicProperty::class;
    }
}
