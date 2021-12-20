<?php
declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class EditShortUrlData
{
    #[Assert\NotBlank]
    private ?string $oldCode;

    #[Assert\NotBlank, Assert\Regex(pattern: "/[A-Za-z0-9\-]+/", message: "Your new custom code likely contains unsupported characters")]
    private ?string $newCode;

    public function getOldCode(): ?string
    {
        return $this->oldCode;
    }

    public function setOldCode(?string $oldCode): self
    {
        $this->oldCode = $oldCode;

        return $this;
    }

    public function getNewCode(): ?string
    {
        return $this->newCode;
    }

    public function setNewCode(?string $newCode): self
    {
        $this->newCode = $newCode;

        return $this;
    }

    public function codesIdentical(): bool
    {
        return $this->newCode === $this->oldCode;
    }
}
