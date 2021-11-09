<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\ReservationStatus;
use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\DateRange;
use App\Validator\IsOfferAvailable;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 * @DateRange
 * @IsOfferAvailable
 */
#[ApiResource(
    normalizationContext: ['groups' => ['reservation:read']],
    denormalizationContext: ['groups' => ['reservation:write']],
)]
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reservation:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"reservation:read", "reservation:write"})
     * @Assert\NotNull
     */
    private $offer;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reservation:read", "reservation:write"})
     * @Assert\NotNull
     * @Assert\Type("\DateTimeInterface")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reservation:read", "reservation:write"})
     * @Assert\NotNull
     * @Assert\Type("\DateTimeInterface")
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"reservation:read", "reservation:write"})
     * @Assert\NotNull
     * @Assert\Positive
     */
    private $unitPrice;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"reservation:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"reservation:read"})
     */
    private $lastModified;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"reservation:read", "reservation:write"})
     * @Assert\NotNull
     */
    private $client;

    /**
     * @ORM\Column(type=ReservationStatus::class, length=255, nullable=true)
     * @Groups({"reservation:read"})
     */
    private $status = 'pending';

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->lastModified;
    }

    public function setLastModified(?\DateTimeInterface $lastModified): self
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getStatus(): ?ReservationStatus
    {
        return ReservationStatus::from($this->status);
    }

    public function setStatus(?string $status): self
    {
        $this->status = ReservationStatus::from($status);

        return $this;
    }
}
