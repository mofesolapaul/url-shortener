<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\ShortUrl;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UrlShortenerService
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    private function generateUniqueCode(ObjectRepository $repository): string
    {
        $code = CodeGeneratorService::generate();
        while ($repository->findOneBy(['code' => $code])) {
            $code = CodeGeneratorService::generate();
        }

        return $code;
    }

    public function shorten(string $url): ShortUrl
    {
        $repo = $this->manager->getRepository(ShortUrl::class);
        $shortUrl = $repo->findOneBy(['fullUrl' => $url]) ??
            (new ShortUrl())
                ->setCode($this->generateUniqueCode($repo))
                ->setFullUrl($url);

        $this->manager->persist($shortUrl);
        $this->manager->flush();

        return $shortUrl;
    }
}
