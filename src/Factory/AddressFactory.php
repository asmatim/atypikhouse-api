<?php

namespace App\Factory;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Address>
 *
 * @method static Address|Proxy createOne(array $attributes = [])
 * @method static Address[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Address|Proxy find(object|array|mixed $criteria)
 * @method static Address|Proxy findOrCreate(array $attributes)
 * @method static Address|Proxy first(string $sortedField = 'id')
 * @method static Address|Proxy last(string $sortedField = 'id')
 * @method static Address|Proxy random(array $attributes = [])
 * @method static Address|Proxy randomOrCreate(array $attributes = [])
 * @method static Address[]|Proxy[] all()
 * @method static Address[]|Proxy[] findBy(array $attributes)
 * @method static Address[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Address[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AddressRepository|RepositoryProxy repository()
 * @method Address|Proxy create(array|callable $attributes = [])
 */
final class AddressFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $city = null;
        try {
            $city = CityFactory::find(['name' => 'Paris']);
        } catch (\Throwable $th) {
            $city = CityFactory::random();
        }
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'latitude' => self::faker()->latitude(10, 81),
            'longitude' => self::faker()->longitude(35, 70),
            'city' => $city,
            'line1' => self::faker()->words(3, true),
            'postalCode' => self::faker()->numberBetween(1000, 98000)
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Address $address) {})
        ;
    }

    protected static function getClass(): string
    {
        return Address::class;
    }
}
