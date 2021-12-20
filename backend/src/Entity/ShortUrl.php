<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ShortUrlRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ShortUrlRepository::class)
 */
class ShortUrl implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"edit"})
     */
    private ?string $code;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(groups={"create"})
     * @Assert\Url(protocols = {"http", "https", "ftp"}, groups={"create"})
     * @Assert\Regex(pattern="/.+\..+/", message="Url appears invalid, please double-check.", groups={"create"})
     */
    private ?string $fullUrl;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getFullUrl(): ?string
    {
        return $this->fullUrl;
    }

    public function setFullUrl(string $fullUrl): self
    {
        $this->fullUrl = $fullUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function jsonSerialize()
    {
    }
}
