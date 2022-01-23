<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class TestUtil extends ApiTestCase
{

    public static function createClientWithCredentials()
    {
        return static::createClient([], ['headers' => ['X-APP-ID' => 'nextjs', 'X-APP-SECRET' => 'jRGxlaNOSyZpvK5fExpErAhXrQR/2jYp0gaznR/v2+I=']]);
    }
}
