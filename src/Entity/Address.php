<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['address:read']],
    denormalizationContext: ['groups' => ['address:write']],
)]
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"address:read","offer:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"address:read","address:write"})
     * @Assert\NotNull
     * @Assert\NotBlank
     * @
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"address:read","address:write"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $longitude;

    /**
     * @ORM\OneToOne(targetEntity=Offer::class, mappedBy="address", cascade={"persist", "remove"})
     * @Groups({"address:read","address:write"})
     * @Assert\NotNull
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity=City::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"address:read","address:write","offer:read"})
     * @Assert\NotNull
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        // unset the owning side of the relation if necessary
        if ($offer === null && $this->offer !== null) {
            $this->offer->setAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($offer !== null && $offer->getAddress() !== $this) {
            $offer->setAddress($this);
        }

        $this->offer = $offer;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
