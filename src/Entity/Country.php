<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['country:read']],
    denormalizationContext: ['groups' => ['country:write']],
)]
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"country:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"country:read","country:write"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Region::class, mappedBy="country", orphanRemoval=true)
     * @Groups({"country:read"})
     */
    private $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
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
     * @return Collection|Region[]
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions[] = $region;
            $region->setCountry($this);
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        if ($this->regions->removeElement($region)) {
            // set the owning side to null (unless already changed)
            if ($region->getCountry() === $this) {
                $region->setCountry(null);
            }
        }

        return $this;
    }
}
