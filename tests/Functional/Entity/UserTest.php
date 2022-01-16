<?php

namespace App\Tests\Functional\Entity;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserTest extends ApiTestCase
{
    use ResetDatabase;

    protected string $USER_URI = "/api/users";

    public function testCreateUserWithUserRole(): void
    {
        $client = static::createClient();

        $client->request('POST', $this->USER_URI, [
            'json' =>
            [
                "firstName" => "Alexandre",
                "lastName" => "Marchand",
                "birthdate" => "1984-04-16",
                "password" => "azerty",
                "phoneNumber" => "0611223344",
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
        $client = static::createClient();

        $client->request('POST', $this->USER_URI, [
            'json' =>
            [
                "firstName" => "Alexandre",
                "lastName" => "Marchand",
                "birthdate" => "1984-04-16",
                "password" => "azerty",
                "phoneNumber" => "0611223344",
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
}
