<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DynamicPropertyValueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DynamicPropertyValueRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['dynamicPropertyValue:read']],
    denormalizationContext: ['groups' => ['dynamicPropertyValue:write']],
)]
class DynamicPropertyValue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"dynamicPropertyValue:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="dynamicPropertyValues")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dynamicPropertyValue:read","dynamicPropertyValue:write"})
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity=DynamicProperty::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"dynamicPropertyValue:read","dynamicPropertyValue:write"})
     */
    private $dynamicProperty;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"dynamicPropertyValue:read","dynamicPropertyValue:write"})
     */
    private $value;

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

    public function getDynamicProperty(): ?DynamicProperty
    {
        return $this->dynamicProperty;
    }

    public function setDynamicProperty(?DynamicProperty $dynamicProperty): self
    {
        $this->dynamicProperty = $dynamicProperty;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
