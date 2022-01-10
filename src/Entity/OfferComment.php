<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OfferCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\CanPostComment;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=OfferCommentRepository::class)
 * @CanPostComment
 */
#[ApiResource(
    normalizationContext: ['groups' => ['offerComment:read']],
    denormalizationContext: ['groups' => ['offerComment:write']],
    paginationItemsPerPage: 9
)]
#[ApiFilter(SearchFilter::class, properties: ["offer" => "exact" ,"client" => "exact"])]
class OfferComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"offerComment:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"offerComment:read","offerComment:write"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Offer::class, inversedBy="offerComments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"offerComment:read","offerComment:write"})
     * @Assert\NotNull
     */
    private $offer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"offerComment:read","offerComment:write"})
     * @Assert\NotNull
     */
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }
}
