<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OfferTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OfferTypeRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['offerType:read']],
    denormalizationContext: ['groups' => ['offerType:write']],
)]
class OfferType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"offerType:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"offerType:read","offerType:write"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Offer::class, mappedBy="offerType")
     */
    private $offers;

    /**
     * @ORM\OneToMany(targetEntity=DynamicProperty::class, mappedBy="offerType")
     * @Groups({"offerType:read"})
     */
    private $dynamicProperties;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->dynamicProperties = new ArrayCollection();
    }

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

    /**
     * @return Collection|Offer[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setOfferType($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getOfferType() === $this) {
                $offer->setOfferType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DynamicProperty[]
     */
    public function getDynamicProperties(): Collection
    {
        return $this->dynamicProperties;
    }

    public function addDynamicProperty(DynamicProperty $dynamicProperty): self
    {
        if (!$this->dynamicProperties->contains($dynamicProperty)) {
            $this->dynamicProperties[] = $dynamicProperty;
            $dynamicProperty->setOfferType($this);
        }

        return $this;
    }

    public function removeDynamicProperty(DynamicProperty $dynamicProperty): self
    {
        if ($this->dynamicProperties->removeElement($dynamicProperty)) {
            // set the owning side to null (unless already changed)
            if ($dynamicProperty->getOfferType() === $this) {
                $dynamicProperty->setOfferType(null);
            }
        }

        return $this;
    }
}
