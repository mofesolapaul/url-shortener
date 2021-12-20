<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\ShortUrlRepository;
use Psr\Cache\CacheItemPoolInterface;

class CacheService
{
    private CacheItemPoolInterface $adapter;
    private ShortUrlRepository $repository;

    public function __construct(
        CacheItemPoolInterface $adapter,
        ShortUrlRepository $repository
    ) {
        $this->adapter = $adapter;
        $this->repository = $repository;
    }

    public function fetch(string $code): ?string
    {
        $cacheItem = $this->adapter->getItem($code);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $shortUrl = $this->repository->findOneBy(['code' => $code]);
        if ($shortUrl) {
            $cacheItem->set($shortUrl->getFullUrl());
            $this->adapter->save($cacheItem);
        }

        return $shortUrl?->getFullUrl();
    }
}
