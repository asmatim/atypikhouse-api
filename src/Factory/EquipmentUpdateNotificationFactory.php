<?php

namespace App\Factory;

use App\Entity\EquipmentUpdateNotification;
use App\Repository\EquipmentUpdateNotificationRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<EquipmentUpdateNotification>
 *
 * @method static EquipmentUpdateNotification|Proxy createOne(array $attributes = [])
 * @method static EquipmentUpdateNotification[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static EquipmentUpdateNotification|Proxy find(object|array|mixed $criteria)
 * @method static EquipmentUpdateNotification|Proxy findOrCreate(array $attributes)
 * @method static EquipmentUpdateNotification|Proxy first(string $sortedField = 'id')
 * @method static EquipmentUpdateNotification|Proxy last(string $sortedField = 'id')
 * @method static EquipmentUpdateNotification|Proxy random(array $attributes = [])
 * @method static EquipmentUpdateNotification|Proxy randomOrCreate(array $attributes = [])
 * @method static EquipmentUpdateNotification[]|Proxy[] all()
 * @method static EquipmentUpdateNotification[]|Proxy[] findBy(array $attributes)
 * @method static EquipmentUpdateNotification[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static EquipmentUpdateNotification[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EquipmentUpdateNotificationRepository|RepositoryProxy repository()
 * @method EquipmentUpdateNotification|Proxy create(array|callable $attributes = [])
 */
final class EquipmentUpdateNotificationFactory extends ModelFactory
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
            // ->afterInstantiate(function(EquipmentUpdateNotification $equipmentUpdateNotification) {})
        ;
    }

    protected static function getClass(): string
    {
        return EquipmentUpdateNotification::class;
    }
}
