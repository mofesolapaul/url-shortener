<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Entity\ShortUrl;
use App\Repository\ShortUrlRepository;

class FetchShortUrlUseCase
{
    private ShortUrlRepository $urlRepository;

    public function __construct(ShortUrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function execute(string $code): ?ShortUrl
    {
        return $this->urlRepository->findOneBy([
            'code' => $code
        ]);
    }
}
