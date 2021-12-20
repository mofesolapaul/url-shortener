<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Entity\ShortUrl;
use App\Service\UrlShortenerService;

class CreateShortUrlUseCase
{
    private UrlShortenerService $urlShortenerService;

    public function __construct(
        UrlShortenerService $urlShortenerService,
    ) {
        $this->urlShortenerService = $urlShortenerService;
    }

    public function execute(ShortUrl $data): string
    {
        return $this->urlShortenerService->generateHref(
            $this->urlShortenerService->shorten($data->getFullUrl())
        );
    }
}
