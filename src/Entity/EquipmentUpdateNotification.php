<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EquipmentUpdateNotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EquipmentUpdateNotificationRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['equipmentUpdateNotification:read']],
    denormalizationContext: ['groups' => ['equipmentUpdateNotification:write']],
)]
class EquipmentUpdateNotification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"equipmentUpdateNotification:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"equipmentUpdateNotification:read","equipmentUpdateNotification:write"})
     */
    private $isSent;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"equipmentUpdateNotification:read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Equipment::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"equipmentUpdateNotification:read","equipmentUpdateNotification:write"})
     */
    private $equipment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="equipmentUpdateNotifications")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"equipmentUpdateNotification:read","equipmentUpdateNotification:write"})
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

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

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
