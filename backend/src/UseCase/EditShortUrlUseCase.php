<?php
declare(strict_types=1);

namespace App\UseCase;

use App\Entity\ShortUrl;
use App\Exception\ApiCallException;
use App\Model\EditShortUrlData;
use App\Service\UrlShortenerService;
use Doctrine\ORM\EntityManagerInterface;

class EditShortUrlUseCase
{
    private UrlShortenerService $urlShortenerService;
    private EntityManagerInterface $manager;

    public function __construct(
        UrlShortenerService $urlShortenerService,
        EntityManagerInterface $manager
    ) {
        $this->urlShortenerService = $urlShortenerService;
        $this->manager = $manager;
    }

    public function execute(EditShortUrlData $data): ?string
    {
        $repo = $this->manager->getRepository(ShortUrl::class);
        /** @var ShortUrl $shortUrl */
        $shortUrl = $repo->findOneBy(['code' => $data->getOldCode()]);

        if (!$shortUrl) {
            throw new ApiCallException('The original short url could not be found.');
        }
        if ($data->codesIdentical()) {
            return $this->urlShortenerService->generateHref($shortUrl);
        }
        $existingUrl = $repo->findBy(['code' => $data->getNewCode()]);
        if ($existingUrl) {
            return null;
        }

        $shortUrl->setCode($data->getNewCode());
        $this->manager->flush();

        return $this->urlShortenerService->generateHref($shortUrl);
    }
}
