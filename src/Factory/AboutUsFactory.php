<?php

namespace App\Factory;

use App\Entity\AboutUs;
use App\Repository\AboutUsRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<AboutUs>
 *
 * @method static AboutUs|Proxy createOne(array $attributes = [])
 * @method static AboutUs[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AboutUs|Proxy find(object|array|mixed $criteria)
 * @method static AboutUs|Proxy findOrCreate(array $attributes)
 * @method static AboutUs|Proxy first(string $sortedField = 'id')
 * @method static AboutUs|Proxy last(string $sortedField = 'id')
 * @method static AboutUs|Proxy random(array $attributes = [])
 * @method static AboutUs|Proxy randomOrCreate(array $attributes = [])
 * @method static AboutUs[]|Proxy[] all()
 * @method static AboutUs[]|Proxy[] findBy(array $attributes)
 * @method static AboutUs[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static AboutUs[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AboutUsRepository|RepositoryProxy repository()
 * @method AboutUs|Proxy create(array|callable $attributes = [])
 */
final class AboutUsFactory extends ModelFactory
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
            'content' => self::faker()->paragraphs(7, true),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(AboutUs $aboutUs) {})
        ;
    }

    protected static function getClass(): string
    {
        return AboutUs::class;
    }
}
