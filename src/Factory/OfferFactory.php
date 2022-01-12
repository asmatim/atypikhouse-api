<?php

namespace App\Factory;

use App\Entity\Offer;
use App\Enum\OfferStatus;
use App\Repository\OfferRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Offer>
 *
 * @method static Offer|Proxy createOne(array $attributes = [])
 * @method static Offer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Offer|Proxy find(object|array|mixed $criteria)
 * @method static Offer|Proxy findOrCreate(array $attributes)
 * @method static Offer|Proxy first(string $sortedField = 'id')
 * @method static Offer|Proxy last(string $sortedField = 'id')
 * @method static Offer|Proxy random(array $attributes = [])
 * @method static Offer|Proxy randomOrCreate(array $attributes = [])
 * @method static Offer[]|Proxy[] all()
 * @method static Offer[]|Proxy[] findBy(array $attributes)
 * @method static Offer[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Offer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OfferRepository|RepositoryProxy repository()
 * @method Offer|Proxy create(array|callable $attributes = [])
 */
final class OfferFactory extends ModelFactory
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
            'title' => self::faker()->text(30),
            'unitPrice' => self::faker()->numberBetween(40, 300),
            'offerType' => OfferTypeFactory::random(),
            'summary' => self::faker()->paragraph(3),
            'description' => self::faker()->paragraphs(4, true),
            'capacity' => self::faker()->numberBetween(1, 4),
            'nbBeds' => self::faker()->numberBetween(1, 4),
            'media' => MediaFactory::new()->many(self::faker()->numberBetween(1, 7)),
            'highlights' => HighlightFactory::new()->many(self::faker()->numberBetween(3, 6)),
            'address' => AddressFactory::createOne(),
            'status' => OfferStatus::PUBLISHED()
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Offer $offer) {})
        ;
    }

    protected static function getClass(): string
    {
        return Offer::class;
    }
}
