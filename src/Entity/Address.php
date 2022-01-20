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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"address:read"} )
     * @Assert\NotBlank(allowNull=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"address:read"} )
     * @Assert\NotBlank(allowNull=true)
     */
    private $longitude;

    /**
     * @ORM\OneToOne(targetEntity=Offer::class, mappedBy="address", cascade={"persist", "remove"})
     * @Groups({"address:read"} )
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity=City::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"address:read", "offer:read", "offer:write"})
     * @Assert\NotNull
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"offer:write", "address:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $line1;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"offer:write", "address:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $postalCode;

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

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): self
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }
}
