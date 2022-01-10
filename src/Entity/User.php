<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"email" : "exact"})
 * @UniqueEntity("email")
 */
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    collectionOperations: [
        'get',
        'post' => ['validation_groups' => ['Default', 'postValidation']]
    ],
    itemOperations: [
        'delete',
        'get',
        'put'
    ],
    paginationItemsPerPage: 9
)]
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read","offerComment:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $externalId;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"user:read","user:write","offerComment:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"user:read","user:write","offerComment:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"user:read","user:write"})
     * @Assert\Type("\DateTimeInterface")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Groups("user:write")
     * @SerializedName("password")
     * @Assert\NotNull(groups={"postValidation"})
     * @Assert\NotBlank(groups={"postValidation"})
     * @Assert\Length(min = 6)
     */
    private $plainPassword;

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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read","user:write"})
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read","user:write"})
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"user:read","user:write"})
     */
    private $roles = [];

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->equipmentUpdateNotifications = new ArrayCollection();
        $this->dynamicPropertyUpdateNotifications = new ArrayCollection();
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }

    public function getUserIdentifier()
    {
        return $this->getEmail();
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

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }
}
