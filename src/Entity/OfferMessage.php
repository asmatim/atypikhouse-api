<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OfferMessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OfferMessageRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['offerMessage:read']],
    denormalizationContext: ['groups' => ['offerMessage:write']],
    paginationItemsPerPage: 9
)]
class OfferMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"offerMessage:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"offerMessage:read","offerMessage:write"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"offerMessage:read","offerMessage:write"})
     * @Assert\NotNull
     */
    private $fromUser;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"offerMessage:read","offerMessage:write"})
     * @Assert\NotNull
     */
    private $toUser;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"offerMessage:read","offerMessage:write"})
     * @Assert\NotNull
     */
    private $offer;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"offerMessage:read"})
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getFromUser(): ?User
    {
        return $this->fromUser;
    }

    public function setFromUser(?User $fromUser): self
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    public function getToUser(): ?User
    {
        return $this->toUser;
    }

    public function setToUser(?User $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

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
}
