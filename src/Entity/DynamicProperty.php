<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\DynamicPropertyType;
use App\Repository\DynamicPropertyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DynamicPropertyRepository::class)
 */
#[ApiResource]
class DynamicProperty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMandatory;

    /**
     * @ORM\Column(type=DynamicPropertyType::class, length=50)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=OfferType::class, inversedBy="dynamicProperties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offerType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsMandatory(): ?bool
    {
        return $this->isMandatory;
    }

    public function setIsMandatory(bool $isMandatory): self
    {
        $this->isMandatory = $isMandatory;

        return $this;
    }

    public function getType(): ?DynamicPropertyType
    {
        return DynamicPropertyType::from($this->type);
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOfferType(): ?OfferType
    {
        return $this->offerType;
    }

    public function setOfferType(?OfferType $offerType): self
    {
        $this->offerType = $offerType;

        return $this;
    }
}
