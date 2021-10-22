<?php

namespace App\Factory;

use App\Entity\OfferComment;
use App\Repository\OfferCommentRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<OfferComment>
 *
 * @method static OfferComment|Proxy createOne(array $attributes = [])
 * @method static OfferComment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static OfferComment|Proxy find(object|array|mixed $criteria)
 * @method static OfferComment|Proxy findOrCreate(array $attributes)
 * @method static OfferComment|Proxy first(string $sortedField = 'id')
 * @method static OfferComment|Proxy last(string $sortedField = 'id')
 * @method static OfferComment|Proxy random(array $attributes = [])
 * @method static OfferComment|Proxy randomOrCreate(array $attributes = [])
 * @method static OfferComment[]|Proxy[] all()
 * @method static OfferComment[]|Proxy[] findBy(array $attributes)
 * @method static OfferComment[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static OfferComment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OfferCommentRepository|RepositoryProxy repository()
 * @method OfferComment|Proxy create(array|callable $attributes = [])
 */
final class OfferCommentFactory extends ModelFactory
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
            'content' => self::faker()->paragraphs(2, true),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(OfferComment $offerComment) {})
        ;
    }

    protected static function getClass(): string
    {
        return OfferComment::class;
    }
}
