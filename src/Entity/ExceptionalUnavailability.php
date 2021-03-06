<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExceptionalUnavailabilityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\DateRange;

/**
 * @ORM\Entity(repositoryClass=ExceptionalUnavailabilityRepository::class)
 * @DateRange
 */
#[ApiResource(
    normalizationContext: ['groups' => ['offerUnavailability:read']],
    denormalizationContext: ['groups' => ['offerUnavailability:write']],
)]
class ExceptionalUnavailability extends OfferUnavailability
{
    /**
     * @ORM\Column(type="date")
     * @Groups({"offerUnavailability:read","offerUnavailability:write"})
     * @Assert\NotNull
     * @Assert\Type("\DateTimeInterface")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     * @Groups({"offerUnavailability:read","offerUnavailability:write"})
     * @Assert\NotNull
     * @Assert\Type("\DateTimeInterface")
     */
    private $endDate;

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
}
