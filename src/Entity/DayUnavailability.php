<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DayUnavailabilityRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Enum\DayOfWeek;

/**
 * @ORM\Entity(repositoryClass=DayUnavailabilityRepository::class)
 */
#[ApiResource]
class DayUnavailability extends OfferUnavailability
{
    /**
     * @ORM\Column(type=DayOfWeek::class)
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
