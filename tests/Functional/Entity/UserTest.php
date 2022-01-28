<?php

namespace App\Tests\Functional\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Factory\ApiClientFactory;
use App\Tests\TestUtil;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    protected string $USER_URI = "/api/users";

    public function testCreateUserWithUserRole(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $client->request('POST', $this->USER_URI, [
            'json' =>
            [
                "firstName" => "Alexandre",
                "lastName" => "Marchand",
                "birthdate" => "1984-04-16",
                "password" => "azerty",
                "phoneNumber" => "0033611223344",
                "email" => "test.user1@example.com",
                "roles" => [
                    "USER_ROLE"
                ]
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['email' => 'test.user1@example.com', 'roles' => ["USER_ROLE"]]);
    }

    public function testUpdateUserWithUserRole(): void
    {
        $client = TestUtil::createClientWithCredentials();

        $client->request('POST', $this->USER_URI, [
            'json' =>
            [
                "firstName" => "Alexandre",
                "lastName" => "Marchand",
                "birthdate" => "1984-04-16",
                "password" => "azerty",
                "phoneNumber" => "+33611223344",
                "email" => "test.user2@example.com",
                "roles" => [
                    "USER_ROLE"
                ]
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['email' => 'test.user2@example.com', 'roles' => ["USER_ROLE"]]);

        $userIRI = $this->findIriBy(User::class, ["email" => "test.user2@example.com"]);

        $client->request('PUT', $userIRI, [
            'json' =>
            [
                "firstName" => "Julien",
                "password" => "azerty"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['firstName' => 'Julien']);
    }

    // method should run before each test
    protected function setUp(): void
    {
        parent::setUp();
        ApiClientFactory::createOne(["appId" => "nextjs", "appSecret" => "jRGxlaNOSyZpvK5fExpErAhXrQR/2jYp0gaznR/v2+I="]);
    }
}
