<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Service\KeycloakService;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $decoratedDataPersister;
    private KeycloakService $keycloakService;

    public function __construct(ContextAwareDataPersisterInterface $decoratedDataPersister, KeycloakService $keycloakService)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
        $this->keycloakService = $keycloakService;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        if (($context['collection_operation_name'] ?? null) === 'post' ||
            ($context['graphql_operation_name'] ?? null) === 'create'
        ) {
            $this->saveUserInKeycloak($data);
        }

        return $this->decoratedDataPersister->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decoratedDataPersister->remove($data, $context);
    }

    private function saveUserInKeycloak(User $user)
    {
        $this->keycloakService->createUser($user);
    }
}
