<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Entity\ShortUrl;
use App\Service\UrlShortenerService;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class CreateShortUrlUseCase
{
    private UrlShortenerService $urlShortenerService;
    private ContainerBagInterface $container;

    public function __construct(
        UrlShortenerService $urlShortenerService,
        ContainerBagInterface  $container
    ) {
        $this->urlShortenerService = $urlShortenerService;
        $this->container = $container;
    }

    public function execute(ShortUrl $data): string
    {
        $shortUrl = $this->urlShortenerService->shorten($data->getFullUrl());

        return $this->container->get('base.url') . $shortUrl->getCode();
    }
}
