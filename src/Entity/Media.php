<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['media:read']],
    denormalizationContext: ['groups' => ['media:write']],
)]
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"media:read", "offer:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"media:read","media:write", "offer:read" , "favorites:read","reservation:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"media:read","media:write", "offer:read" , "favorites:read","reservation:read"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="media")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"media:read","media:write"})
     * @Assert\NotNull
     */
    private $offer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;

        return $this;
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
}
