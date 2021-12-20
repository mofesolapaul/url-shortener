<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\ShortUrlRepository;
use Psr\Cache\CacheItemPoolInterface;

class CacheService
{
    private CacheItemPoolInterface $adapter;
    private ShortUrlRepository $repository;
    private UrlLogService $logService;

    public function __construct(
        CacheItemPoolInterface $adapter,
        ShortUrlRepository $repository,
        UrlLogService $logService
    ) {
        $this->adapter = $adapter;
        $this->repository = $repository;
        $this->logService = $logService;
    }

    public function fetch(string $code): ?string
    {
        $cacheItem = $this->adapter->getItem($code);
        if ($cacheItem->isHit()) {
            $this->logService->queueAccessLog($code);

            return $cacheItem->get();
        }

        $shortUrl = $this->repository->findOneBy(['code' => $code]);
        if ($shortUrl) {
            $cacheItem->set($shortUrl->getFullUrl());
            $this->adapter->save($cacheItem);
            $this->logService->queueAccessLog($code);
        }

        return $shortUrl?->getFullUrl();
    }
}
