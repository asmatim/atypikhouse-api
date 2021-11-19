<?php

namespace App\Service;

use App\Entity\User;
use RuntimeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class KeycloakService
{

    private $httpClient;
    private $keycloakClientId;
    private $keycloakClientSecret;
    private $keycloakServerUrl;
    private $keycloakRealm;

    public function __construct(HttpClientInterface $client, $keycloakClientId, $keycloakClientSecret, $keycloakServerUrl, $keycloakRealm)
    {
        $this->httpClient = $client;
        $this->keycloakClientId = $keycloakClientId;
        $this->keycloakClientSecret = $keycloakClientSecret;
        $this->keycloakServerUrl = $keycloakServerUrl;
        $this->keycloakRealm = $keycloakRealm;
    }

    public function createUser(User $user)
    {
        $token = $this->getClientToken();
        $bearerToken = "Bearer " . $token;

        $response = $this->httpClient->request('POST', $this->getCreateUserUrl(), [
            'headers' => [
                'Content-Type' => 'application/json ',
                'Authorization' => $bearerToken,
            ],
            'json' => $this->getUserData($user),
        ]);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $contents = $response->toArray();
            return $contents["access_token"];
        }
        if ($response->getStatusCode() !== Response::HTTP_CREATED) {
            //var_dump($response->getContent());
            throw new RuntimeException("Error couldn't create User.");
        }
    }

    public function introspectToken(string $token)
    {
        $response = $this->httpClient->request('POST', $this->getIntrospectUrl(), [
            'body' => [
                'client_id' => $this->keycloakClientId, 'client_secret' => $this->keycloakClientSecret, 'token' => $token,
            ],
        ]);

        if ($response->getStatusCode() == Response::HTTP_OK) {
            // casts the response JSON content to a PHP array
            $contents = $response->toArray();
            $isValidToken = array_key_exists('active', $contents) && $contents['active'] === true;

            if ($isValidToken) {
                return $contents;
            }
        }
        throw new CustomUserMessageAuthenticationException('Invalid Token');
    }

    private function getClientToken()
    {
        $response = $this->httpClient->request('POST', $this->getTokenUrl(), [
            'body' => [
                'client_id' => $this->keycloakClientId, 'client_secret' => $this->keycloakClientSecret, 'grant_type' => 'client_credentials',
            ],
        ]);
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $contents = $response->toArray();
            return $contents["access_token"];
        }
        throw new RuntimeException("Fatal error: couldn't retrieve Access Token.");
    }

    private function getUserData(User $user)
    {
        return [
            "email" => $user->getEmail(),
            "username" => $user->getUsername(),
            "firstName" => $user->getFirstName(),
            "lastName" => $user->getLastName(),
            "enabled" => true,
            "attributes" => [
                "roles" => json_encode($user->getRoles())
            ],
            "credentials" => [
                [
                    "type" => "password",
                    "value" => $user->getPlainPassword(),
                    "temporary" => false,
                ]
            ]
        ];
    }

    private function getTokenUrl()
    {
        return $this->keycloakServerUrl . 'realms/' . $this->keycloakRealm . '/protocol/openid-connect/token';
    }
    
    private function getCreateUserUrl()
    {
        return $this->keycloakServerUrl . 'admin/realms/' . $this->keycloakRealm . '/users';
    }

    private function getIntrospectUrl()
    {
        return $this->keycloakServerUrl . 'realms/' . $this->keycloakRealm . '/protocol/openid-connect/token/introspect';
    }
}
