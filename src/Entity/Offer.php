<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Filters\OfferAvailabilityFilter;
use App\Filters\OfferSearchFilter;
use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use App\Enum\OfferStatus;
use App\Validator\OfferDynamicProperty;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 * @OfferDynamicProperty
 */
#[ApiResource(
    normalizationContext: ['groups' => ['offer:read']],
    denormalizationContext: ['groups' => ['offer:write']],
    paginationItemsPerPage: 9
)]
#[ApiFilter(SearchFilter::class, properties: ["offerType" => "exact", "status" => "exact"])]
#[ApiFilter(OfferSearchFilter::class)]
#[ApiFilter(OfferAvailabilityFilter::class)]
#[ApiFilter(RangeFilter::class, properties: ['capacity', 'unitPrice'])]
class Offer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"offer:read","favorites:read","reservation:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     * @Groups({"offer:read","offer:write" ,"favorites:read","reservation:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"offer:read","offer:write" , "favorites:read","reservation:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $summary;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"offer:read","offer:write" , "favorites:read","reservation:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"offer:read","offer:write" , "favorites:read","reservation:read"})
     * @Assert\NotNull
     * @Assert\Positive
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"offer:read","offer:write" , "favorites:read","reservation:read"})
     * @Assert\NotNull
     * @Assert\PositiveOrZero
     */
    private $nbBeds;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"offer:read","offer:write" , "favorites:read","reservation:read"})
     * @Assert\NotNull
     * @Assert\Positive
     */
    private $unitPrice;

    /**
     * @ORM\OneToMany(targetEntity=OfferUnavailability::class, mappedBy="offer", orphanRemoval=true)
     * @Groups({"offer:read"})
     */
    private $offerUnavailabilities;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="offer", orphanRemoval=true)
     * @Groups({"offer:read" , "favorites:read","reservation:read"})
     */
    private $media;

    /**
     * @ORM\OneToMany(targetEntity=Highlight::class, mappedBy="offer", orphanRemoval=true, cascade={"persist"})
     * @Groups({"offer:read", "offer:write"})
     */
    private $highlights;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="offer", cascade={"persist", "remove"})
     * @Groups({"offer:read", "offer:write"})
     * @Assert\NotNull
     * @Assert\Valid
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="offer")
     */
    private $reservations;

    /**
     * @ORM\ManyToMany(targetEntity=Equipment::class, mappedBy="offers")
     * @Groups({"offer:read", "offer:write"})
     */
    private $equipments;

    /**
     * @ORM\ManyToOne(targetEntity=OfferType::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"offer:read","offer:write"})
     * @Assert\NotNull
     */
    private $offerType;

    /**
     * @ORM\OneToMany(targetEntity=OfferComment::class, mappedBy="offer", orphanRemoval=true)
     * @Groups({"offer:read"})
     */
    private $offerComments;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"offer:read","offer:write"})
     * @Assert\NotNull
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=DynamicPropertyValue::class, mappedBy="offer", cascade={"persist", "remove"})
     * @Groups({"offer:read", "offer:write"})
     * @Assert\Valid
     */
    private $dynamicPropertyValues;

    /**
     * @ORM\Column(type=OfferStatus::class, length=255, nullable=true)
     * @Groups({"offer:read","offer:write"})
     */
    private $status = 'unpublished';

    public function __construct()
    {
        $this->offerUnavailabilities = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->highlights = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->offerComments = new ArrayCollection();
        $this->dynamicPropertyValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getNbBeds(): ?int
    {
        return $this->nbBeds;
    }

    public function setNbBeds(?int $nbBeds): self
    {
        $this->nbBeds = $nbBeds;

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

    /**
     * @return Collection|OfferUnavailability[]
     */
    public function getOfferUnavailabilities(): Collection
    {
        return $this->offerUnavailabilities;
    }

    public function addOfferUnavailability(OfferUnavailability $offerUnavailability): self
    {
        if (!$this->offerUnavailabilities->contains($offerUnavailability)) {
            $this->offerUnavailabilities[] = $offerUnavailability;
            $offerUnavailability->setOffer($this);
        }

        return $this;
    }

    public function removeOfferUnavailability(OfferUnavailability $offerUnavailability): self
    {
        if ($this->offerUnavailabilities->removeElement($offerUnavailability)) {
            // set the owning side to null (unless already changed)
            if ($offerUnavailability->getOffer() === $this) {
                $offerUnavailability->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media[] = $medium;
            $medium->setOffer($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getOffer() === $this) {
                $medium->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Highlight[]
     */
    public function getHighlights(): Collection
    {
        return $this->highlights;
    }

    public function addHighlight(Highlight $highlight): self
    {
        if (!$this->highlights->contains($highlight)) {
            $this->highlights[] = $highlight;
            $highlight->setOffer($this);
        }

        return $this;
    }

    public function removeHighlight(Highlight $highlight): self
    {
        if ($this->highlights->removeElement($highlight)) {
            // set the owning side to null (unless already changed)
            if ($highlight->getOffer() === $this) {
                $highlight->setOffer(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setOffer($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getOffer() === $this) {
                $reservation->setOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Equipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->addOffer($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->removeElement($equipment)) {
            $equipment->removeOffer($this);
        }

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

    /**
     * @return Collection|OfferComment[]
     */
    public function getOfferComments(): Collection
    {
        return $this->offerComments;
    }

    public function addOfferComment(OfferComment $offerComment): self
    {
        if (!$this->offerComments->contains($offerComment)) {
            $this->offerComments[] = $offerComment;
            $offerComment->setOffer($this);
        }

        return $this;
    }

    public function removeOfferComment(OfferComment $offerComment): self
    {
        if ($this->offerComments->removeElement($offerComment)) {
            // set the owning side to null (unless already changed)
            if ($offerComment->getOffer() === $this) {
                $offerComment->setOffer(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|DynamicPropertyValue[]
     */
    public function getDynamicPropertyValues(): Collection
    {
        return $this->dynamicPropertyValues;
    }

    public function addDynamicPropertyValue(DynamicPropertyValue $dynamicPropertyValue): self
    {
        if (!$this->dynamicPropertyValues->contains($dynamicPropertyValue)) {
            $this->dynamicPropertyValues[] = $dynamicPropertyValue;
            $dynamicPropertyValue->setOffer($this);
        }

        return $this;
    }

    public function removeDynamicPropertyValue(DynamicPropertyValue $dynamicPropertyValue): self
    {
        if ($this->dynamicPropertyValues->removeElement($dynamicPropertyValue)) {
            // set the owning side to null (unless already changed)
            if ($dynamicPropertyValue->getOffer() === $this) {
                $dynamicPropertyValue->setOffer(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?OfferStatus
    {
        return OfferStatus::from($this->status);
    }

    public function setStatus(?string $status): self
    {
        $this->status = OfferStatus::from($status);

        return $this;
    }
}
