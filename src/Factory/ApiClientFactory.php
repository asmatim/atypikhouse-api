<?php

namespace App\Factory;

use App\Entity\ApiClient;
use App\Repository\ApiClientRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<ApiClient>
 *
 * @method static ApiClient|Proxy createOne(array $attributes = [])
 * @method static ApiClient[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static ApiClient|Proxy find(object|array|mixed $criteria)
 * @method static ApiClient|Proxy findOrCreate(array $attributes)
 * @method static ApiClient|Proxy first(string $sortedField = 'id')
 * @method static ApiClient|Proxy last(string $sortedField = 'id')
 * @method static ApiClient|Proxy random(array $attributes = [])
 * @method static ApiClient|Proxy randomOrCreate(array $attributes = [])
 * @method static ApiClient[]|Proxy[] all()
 * @method static ApiClient[]|Proxy[] findBy(array $attributes)
 * @method static ApiClient[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static ApiClient[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ApiClientRepository|RepositoryProxy repository()
 * @method ApiClient|Proxy create(array|callable $attributes = [])
 */
final class ApiClientFactory extends ModelFactory
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
            'appId' => self::faker()->text(),
            'appSecret' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(ApiClient $apiClient) {})
        ;
    }

    protected static function getClass(): string
    {
        return ApiClient::class;
    }
}
