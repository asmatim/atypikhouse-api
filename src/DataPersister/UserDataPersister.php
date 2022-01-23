<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Service\KeycloakService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Psr\Log\LoggerInterface;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $decoratedDataPersister;
    //private KeycloakService $keycloakService;
    private $passwordHasher;
    private $logger;

    public function __construct(ContextAwareDataPersisterInterface $decoratedDataPersister, KeycloakService $keycloakService, UserPasswordHasherInterface $passwordHasher, LoggerInterface $logger)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
        //$this->keycloakService = $keycloakService;
        $this->passwordHasher = $passwordHasher;
        $this->logger = $logger;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    // $data is user
    public function persist($data, array $context = [])
    {
        if (($context['collection_operation_name'] ?? null) === 'post') {
            //$createdUserId = $this->saveUserInKeycloak($data);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $data,
                $data->getPlainPassword()
            );

            //$data->setExternalId($createdUserId);
            $data->setPassword($hashedPassword);
            $data->eraseCredentials();
        }

        if (($context['item_operation_name'] ?? null) === 'put') {
            //$this->updateUserInKeycloak($data);

            if (!empty($data->getPlainPassword())) {
                $hashedPassword = $this->passwordHasher->hashPassword(
                    $data,
                    $data->getPlainPassword()
                );
                $data->setPassword($hashedPassword);
            }
            $data->eraseCredentials();
        }

        return $this->decoratedDataPersister->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decoratedDataPersister->remove($data, $context);
    }

    private function saveUserInKeycloak(User $user)
    {
        return $this->keycloakService->createUser($user);
    }

    private function updateUserInKeycloak($data)
    {
        return $this->keycloakService->updateUser($data);
    }
}
