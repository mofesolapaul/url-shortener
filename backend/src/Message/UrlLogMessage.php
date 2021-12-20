<?php
declare(strict_types=1);

namespace App\Message;

final class UrlLogMessage
{
    private string $shortCode;
    private \DateTime $accessTime;

    public function __construct(string $urlId, \DateTime $accessTime)
    {
        $this->shortCode = $urlId;
        $this->accessTime = $accessTime;
    }

    public function getShortCode(): string
    {
        return $this->shortCode;
    }

    public function getAccessTime(): \DateTime
    {
        return $this->accessTime;
    }
}
