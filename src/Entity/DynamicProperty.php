<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\DynamicPropertyType;
use App\Repository\DynamicPropertyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DynamicPropertyRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['dynamicProperty:read']],
    denormalizationContext: ['groups' => ['dynamicProperty:write']],
)]
class DynamicProperty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"dynamicProperty:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dynamicProperty:read","dynamicProperty:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"dynamicProperty:read","dynamicProperty:write"})
     */
    private $isMandatory;

    /**
     * @ORM\Column(type=DynamicPropertyType::class, length=50)
     * @Groups({"dynamicProperty:read","dynamicProperty:write"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=OfferType::class, inversedBy="dynamicProperties")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dynamicProperty:read","dynamicProperty:write"})
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
