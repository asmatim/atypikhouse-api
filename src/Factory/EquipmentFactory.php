<?php

namespace App\Factory;

use App\Entity\Equipment;
use App\Repository\EquipmentRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Equipment>
 *
 * @method static Equipment|Proxy createOne(array $attributes = [])
 * @method static Equipment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Equipment|Proxy find(object|array|mixed $criteria)
 * @method static Equipment|Proxy findOrCreate(array $attributes)
 * @method static Equipment|Proxy first(string $sortedField = 'id')
 * @method static Equipment|Proxy last(string $sortedField = 'id')
 * @method static Equipment|Proxy random(array $attributes = [])
 * @method static Equipment|Proxy randomOrCreate(array $attributes = [])
 * @method static Equipment[]|Proxy[] all()
 * @method static Equipment[]|Proxy[] findBy(array $attributes)
 * @method static Equipment[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Equipment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EquipmentRepository|RepositoryProxy repository()
 * @method Equipment|Proxy create(array|callable $attributes = [])
 */
final class EquipmentFactory extends ModelFactory
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
            // ->afterInstantiate(function(Equipment $equipment) {})
        ;
    }

    protected static function getClass(): string
    {
        return Equipment::class;
    }
}
