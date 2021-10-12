<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AboutUsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AboutUsRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'path' => '/about-us',
        ],
        'post' => [
            'path' => '/about-us',
        ],
    ],
    itemOperations: [
        'get' => [
            'path' => '/about-us/{id}',
        ],
        'put' => [
            'path' => '/about-us/{id}',
        ],
        'delete' => [
            'path' => '/about-us/{id}',
        ],
        'patch' => [
            'path' => '/about-us/{id}',
        ],
    ],
    normalizationContext: ['groups' => ['aboutUs:read']],
    denormalizationContext: ['groups' => ['aboutUs:write']],
)]
class AboutUs
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"aboutUs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"aboutUs:read","aboutUs:write"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
