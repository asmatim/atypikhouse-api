<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DayUnavailabilityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use App\Enum\DayOfWeek;

/**
 * @ORM\Entity(repositoryClass=DayUnavailabilityRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['offerUnavailability:read']],
    denormalizationContext: ['groups' => ['offerUnavailability:write']],
)]
class DayUnavailability extends OfferUnavailability
{
    /**
     * @ORM\Column(type=DayOfWeek::class)
     * @Groups({"offerUnavailability:read","offerUnavailability:write"})
     */
    private $value;

    public function getValue(): ?DayOfWeek
    {
        return DayOfWeek::from($this->value);
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

}
