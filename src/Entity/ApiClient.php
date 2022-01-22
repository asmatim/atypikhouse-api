<?php

namespace App\Entity;

use App\Repository\ApiClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=ApiClientRepository::class)
 */
class ApiClient implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $appId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $appSecret;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppId(): ?string
    {
        return $this->appId;
    }

    public function setAppId(string $appId): self
    {
        $this->appId = $appId;

        return $this;
    }

    public function getAppSecret(): ?string
    {
        return $this->appSecret;
    }

    public function setAppSecret(string $appSecret): self
    {
        $this->appSecret = $appSecret;

        return $this;
    }

    public function getRoles()
    {
        return ["ROLE_APP"];
    }

    public function getPassword()
    {
        // not used in practice
        return;
    }


    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }


    public function getUsername()
    {
        // not used in practice
        return;
    }

    public function getUserIdentifier()
    {
        return $this->getAppId();
    }
}
