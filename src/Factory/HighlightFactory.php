<?php

namespace App\Factory;

use App\Entity\Highlight;
use App\Repository\HighlightRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Highlight>
 *
 * @method static Highlight|Proxy createOne(array $attributes = [])
 * @method static Highlight[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Highlight|Proxy find(object|array|mixed $criteria)
 * @method static Highlight|Proxy findOrCreate(array $attributes)
 * @method static Highlight|Proxy first(string $sortedField = 'id')
 * @method static Highlight|Proxy last(string $sortedField = 'id')
 * @method static Highlight|Proxy random(array $attributes = [])
 * @method static Highlight|Proxy randomOrCreate(array $attributes = [])
 * @method static Highlight[]|Proxy[] all()
 * @method static Highlight[]|Proxy[] findBy(array $attributes)
 * @method static Highlight[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Highlight[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static HighlightRepository|RepositoryProxy repository()
 * @method Highlight|Proxy create(array|callable $attributes = [])
 */
final class HighlightFactory extends ModelFactory
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
            'content' => self::faker()->text(80),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Highlight $highlight) {})
        ;
    }

    protected static function getClass(): string
    {
        return Highlight::class;
    }
}
