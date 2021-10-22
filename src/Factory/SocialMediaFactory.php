<?php

namespace App\Factory;

use App\Entity\SocialMedia;
use App\Repository\SocialMediaRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<SocialMedia>
 *
 * @method static SocialMedia|Proxy createOne(array $attributes = [])
 * @method static SocialMedia[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static SocialMedia|Proxy find(object|array|mixed $criteria)
 * @method static SocialMedia|Proxy findOrCreate(array $attributes)
 * @method static SocialMedia|Proxy first(string $sortedField = 'id')
 * @method static SocialMedia|Proxy last(string $sortedField = 'id')
 * @method static SocialMedia|Proxy random(array $attributes = [])
 * @method static SocialMedia|Proxy randomOrCreate(array $attributes = [])
 * @method static SocialMedia[]|Proxy[] all()
 * @method static SocialMedia[]|Proxy[] findBy(array $attributes)
 * @method static SocialMedia[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static SocialMedia[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static SocialMediaRepository|RepositoryProxy repository()
 * @method SocialMedia|Proxy create(array|callable $attributes = [])
 */
final class SocialMediaFactory extends ModelFactory
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
            'url' => self::faker()->text(),
            'imageUrl' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(SocialMedia $socialMedia) {})
        ;
    }

    protected static function getClass(): string
    {
        return SocialMedia::class;
    }
}
