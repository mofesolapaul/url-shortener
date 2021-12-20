<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UrlLogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlLogRepository::class)
 * @ORM\Table(name="access_log")
 */
class UrlLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private ?int $urlId;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $accessTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlId(): ?int
    {
        return $this->urlId;
    }

    public function setUrlId(?int $urlId): self
    {
        $this->urlId = $urlId;

        return $this;
    }

    public function getAccessTime(): ?\DateTimeInterface
    {
        return $this->accessTime;
    }

    public function setAccessTime(\DateTimeInterface $accessTime): self
    {
        $this->accessTime = $accessTime;

        return $this;
    }
}
