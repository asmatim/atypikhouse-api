<?php

namespace App\Tests\Functional\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApiClientFactory;
use App\Tests\TestUtil;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class LoginTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected string $USER_URI = "/api/users";
    protected string $LOGIN_URI = "/login";

    public function testLoginUserWithSuccess(): void
    {
        $client = TestUtil::createClientWithCredentials();

        // create user
        $client->request('POST', $this->USER_URI, [
            'json' =>
            [
                "firstName" => "Alexandre",
                "lastName" => "Marchand",
                "password" => "azerty",
                "email" => "test.user1@example.com",
                "roles" => [
                    "USER_ROLE"
                ]
            ],
        ]);

        //POST to /login
        $client->request('POST', $this->LOGIN_URI, [
            'json' =>
            [
                "email" => "test.user1@example.com",
                "password" => "azerty",
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(["user" => ["email" => "test.user1@example.com"]]);
    }

    public function testLoginUserError(): void
    {
        $client = TestUtil::createClientWithCredentials();

        // create user
        $client->request('POST', $this->USER_URI, [
            'json' =>
            [
                "firstName" => "Alexandre",
                "lastName" => "Marchand",
                "password" => "azerty",
                "email" => "test.user1@example.com",
                "roles" => [
                    "USER_ROLE"
                ]
            ],
        ]);

        //POST to /login
        $client->request('POST', $this->LOGIN_URI, [
            'json' =>
            [
                "email" => "test.user1@example.com",
                // wrong password
                "password" => "azert",
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['error' => 'Incorrect Credentials']);
    }

    // method should run before each test
    protected function setUp(): void
    {
        parent::setUp();
        ApiClientFactory::createOne(["appId" => "nextjs", "appSecret" => "jRGxlaNOSyZpvK5fExpErAhXrQR/2jYp0gaznR/v2+I="]);
    }
}
