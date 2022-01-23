<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Psr\Log\LoggerInterface;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $decoratedDataPersister;
    private $passwordHasher;
    private $logger;

    public function __construct(ContextAwareDataPersisterInterface $decoratedDataPersister, UserPasswordHasherInterface $passwordHasher, LoggerInterface $logger)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
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
            $hashedPassword = $this->passwordHasher->hashPassword(
                $data,
                $data->getPlainPassword()
            );

            $data->setPassword($hashedPassword);
            $data->eraseCredentials();
        }

        if (($context['item_operation_name'] ?? null) === 'put') {

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
}
