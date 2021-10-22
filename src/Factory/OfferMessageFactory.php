<?php

namespace App\Factory;

use App\Entity\OfferMessage;
use App\Repository\OfferMessageRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<OfferMessage>
 *
 * @method static OfferMessage|Proxy createOne(array $attributes = [])
 * @method static OfferMessage[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static OfferMessage|Proxy find(object|array|mixed $criteria)
 * @method static OfferMessage|Proxy findOrCreate(array $attributes)
 * @method static OfferMessage|Proxy first(string $sortedField = 'id')
 * @method static OfferMessage|Proxy last(string $sortedField = 'id')
 * @method static OfferMessage|Proxy random(array $attributes = [])
 * @method static OfferMessage|Proxy randomOrCreate(array $attributes = [])
 * @method static OfferMessage[]|Proxy[] all()
 * @method static OfferMessage[]|Proxy[] findBy(array $attributes)
 * @method static OfferMessage[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static OfferMessage[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OfferMessageRepository|RepositoryProxy repository()
 * @method OfferMessage|Proxy create(array|callable $attributes = [])
 */
final class OfferMessageFactory extends ModelFactory
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
            'message' => self::faker()->text(),
            'createdAt' => self::faker()->datetime(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(OfferMessage $offerMessage) {})
        ;
    }

    protected static function getClass(): string
    {
        return OfferMessage::class;
    }
}
