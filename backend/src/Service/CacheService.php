<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\ShortUrl;
use Psr\Cache\CacheItemPoolInterface;

class CacheService
{
    private CacheItemPoolInterface $adapter;
    private UrlShortenerService $shortenerService;

    public function __construct(
        CacheItemPoolInterface $adapter,
        UrlShortenerService $shortenerService
    ) {
        $this->adapter = $adapter;
        $this->shortenerService = $shortenerService;
    }

    public function fetch(string $url): ShortUrl
    {
        $cacheKey = sha1($url);
        $cacheItem = $this->adapter->getItem($cacheKey);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $shortUrl = $this->shortenerService->shorten($url);
        $cacheItem->set($shortUrl);
        $this->adapter->save($cacheItem);

        return $shortUrl;
    }
}
