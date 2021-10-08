<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
)]
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"user:read","user:write"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"user:read","user:write"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"user:read","user:write"})
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:write"})
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="client")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity=Offer::class, mappedBy="owner")
     */
    private $offers;

    /**
     * @ORM\OneToMany(targetEntity=EquipmentUpdateNotification::class, mappedBy="owner")
     */
    private $equipmentUpdateNotifications;

    /**
     * @ORM\OneToMany(targetEntity=DynamicPropertyUpdateNotification::class, mappedBy="owner")
     */
    private $dynamicPropertyUpdateNotifications;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->equipmentUpdateNotifications = new ArrayCollection();
        $this->dynamicPropertyUpdateNotifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
            $reservation->setClient($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getClient() === $this) {
                $reservation->setClient(null);
            }
        }

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
            $offer->setOwner($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getOwner() === $this) {
                $offer->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EquipmentUpdateNotification[]
     */
    public function getEquipmentUpdateNotifications(): Collection
    {
        return $this->equipmentUpdateNotifications;
    }

    public function addEquipmentUpdateNotification(EquipmentUpdateNotification $equipmentUpdateNotification): self
    {
        if (!$this->equipmentUpdateNotifications->contains($equipmentUpdateNotification)) {
            $this->equipmentUpdateNotifications[] = $equipmentUpdateNotification;
            $equipmentUpdateNotification->setOwner($this);
        }

        return $this;
    }

    public function removeEquipmentUpdateNotification(EquipmentUpdateNotification $equipmentUpdateNotification): self
    {
        if ($this->equipmentUpdateNotifications->removeElement($equipmentUpdateNotification)) {
            // set the owning side to null (unless already changed)
            if ($equipmentUpdateNotification->getOwner() === $this) {
                $equipmentUpdateNotification->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DynamicPropertyUpdateNotification[]
     */
    public function getDynamicPropertyUpdateNotifications(): Collection
    {
        return $this->dynamicPropertyUpdateNotifications;
    }

    public function addDynamicPropertyUpdateNotification(DynamicPropertyUpdateNotification $dynamicPropertyUpdateNotification): self
    {
        if (!$this->dynamicPropertyUpdateNotifications->contains($dynamicPropertyUpdateNotification)) {
            $this->dynamicPropertyUpdateNotifications[] = $dynamicPropertyUpdateNotification;
            $dynamicPropertyUpdateNotification->setOwner($this);
        }

        return $this;
    }

    public function removeDynamicPropertyUpdateNotification(DynamicPropertyUpdateNotification $dynamicPropertyUpdateNotification): self
    {
        if ($this->dynamicPropertyUpdateNotifications->removeElement($dynamicPropertyUpdateNotification)) {
            // set the owning side to null (unless already changed)
            if ($dynamicPropertyUpdateNotification->getOwner() === $this) {
                $dynamicPropertyUpdateNotification->setOwner(null);
            }
        }

        return $this;
    }
}
