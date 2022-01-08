<?php

namespace App\Service;

use App\Entity\User;
use Psr\Log\LoggerInterface;
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
    private $logger;

    public function __construct(HttpClientInterface $client, $keycloakClientId, $keycloakClientSecret, $keycloakServerUrl, $keycloakRealm, LoggerInterface $logger)
    {
        $this->httpClient = $client;
        $this->keycloakClientId = $keycloakClientId;
        $this->keycloakClientSecret = $keycloakClientSecret;
        $this->keycloakServerUrl = $keycloakServerUrl;
        $this->keycloakRealm = $keycloakRealm;
        $this->logger = $logger;
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

        if ($response->getStatusCode() == Response::HTTP_CREATED) {
            return $this->getUserExternalIdFromHeader($response);
        }

        if ($response->getStatusCode() !== Response::HTTP_CREATED) {
            throw new RuntimeException("Error couldn't create User.");
        }
    }

    public function updateUser(User $user)
    {
        $token = $this->getClientToken();
        $bearerToken = "Bearer " . $token;

        $this->logger->debug(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>update");
        $this->logger->debug($this->getUpdateUserUrl($user->getExternalId()));

        $response = $this->httpClient->request('PUT', $this->getUpdateUserUrl($user->getExternalId()), [
            'headers' => [
                'Content-Type' => 'application/json ',
                'Authorization' => $bearerToken,
            ],
            'json' => $this->getUserData($user),
        ]);

        if ($response->getStatusCode() == Response::HTTP_NO_CONTENT) {
            return;
        }

        if ($response->getStatusCode() !== Response::HTTP_NO_CONTENT) {
            throw new RuntimeException("Error couldn't update User.");
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
        $userData = [
            "email" => $user->getEmail(),
            "username" => $user->getUsername(),
            "firstName" => $user->getFirstName(),
            "lastName" => $user->getLastName(),
            "enabled" => true,
            "attributes" => [
                "roles" => json_encode($user->getRoles())
            ]
        ];

        if (!empty($user->getPlainPassword())) {
            $userData["credentials"] = [
                [
                    "type" => "password",
                    "value" => $user->getPlainPassword(),
                    "temporary" => false,
                ]
            ];
        }

        $this->logger->debug(">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>payload keycloak user data");
        $this->logger->debug(var_export($userData, true));

        return $userData;
    }

    private function getUserExternalIdFromHeader($response)
    {
        $responseHeaders = $response->getHeaders();
        $userLocationHeader = $responseHeaders["location"];

        if (count($userLocationHeader) == 0) {
            throw new RuntimeException("Error couldn't create User.");
        }

        // get the first element of the array and remove it from array
        $userLocation = array_shift($userLocationHeader);

        $splitedUserLocation = explode("/", $userLocation);

        $userId = end($splitedUserLocation);

        return $userId;
    }

    private function getTokenUrl()
    {
        return $this->keycloakServerUrl . 'realms/' . $this->keycloakRealm . '/protocol/openid-connect/token';
    }

    private function getCreateUserUrl()
    {
        return $this->keycloakServerUrl . 'admin/realms/' . $this->keycloakRealm . '/users';
    }

    private function getUpdateUserUrl($userExternalId)
    {
        return $this->keycloakServerUrl . 'admin/realms/' . $this->keycloakRealm . '/users/' . $userExternalId;
    }

    private function getIntrospectUrl()
    {
        return $this->keycloakServerUrl . 'realms/' . $this->keycloakRealm . '/protocol/openid-connect/token/introspect';
    }
}
