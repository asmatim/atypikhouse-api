<?php

namespace App\Factory;

use App\Entity\DynamicPropertyUpdateNotification;
use App\Repository\DynamicPropertyUpdateNotificationRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<DynamicPropertyUpdateNotification>
 *
 * @method static DynamicPropertyUpdateNotification|Proxy createOne(array $attributes = [])
 * @method static DynamicPropertyUpdateNotification[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static DynamicPropertyUpdateNotification|Proxy find(object|array|mixed $criteria)
 * @method static DynamicPropertyUpdateNotification|Proxy findOrCreate(array $attributes)
 * @method static DynamicPropertyUpdateNotification|Proxy first(string $sortedField = 'id')
 * @method static DynamicPropertyUpdateNotification|Proxy last(string $sortedField = 'id')
 * @method static DynamicPropertyUpdateNotification|Proxy random(array $attributes = [])
 * @method static DynamicPropertyUpdateNotification|Proxy randomOrCreate(array $attributes = [])
 * @method static DynamicPropertyUpdateNotification[]|Proxy[] all()
 * @method static DynamicPropertyUpdateNotification[]|Proxy[] findBy(array $attributes)
 * @method static DynamicPropertyUpdateNotification[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static DynamicPropertyUpdateNotification[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static DynamicPropertyUpdateNotificationRepository|RepositoryProxy repository()
 * @method DynamicPropertyUpdateNotification|Proxy create(array|callable $attributes = [])
 */
final class DynamicPropertyUpdateNotificationFactory extends ModelFactory
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
            'isSent' => self::faker()->boolean(),
            'createdAt' => self::faker()->datetime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(DynamicPropertyUpdateNotification $dynamicPropertyUpdateNotification) {})
        ;
    }

    protected static function getClass(): string
    {
        return DynamicPropertyUpdateNotification::class;
    }
}
