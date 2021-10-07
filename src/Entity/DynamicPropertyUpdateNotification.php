<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DynamicPropertyUpdateNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DynamicPropertyUpdateNotificationRepository::class)
 */
#[ApiResource]
class DynamicPropertyUpdateNotification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSent;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=DynamicProperty::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $dynamicProperty;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="dynamicPropertyUpdateNotifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsSent(): ?bool
    {
        return $this->isSent;
    }

    public function setIsSent(bool $isSent): self
    {
        $this->isSent = $isSent;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDynamicProperty(): ?DynamicProperty
    {
        return $this->dynamicProperty;
    }

    public function setDynamicProperty(?DynamicProperty $dynamicProperty): self
    {
        $this->dynamicProperty = $dynamicProperty;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
