<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\ShortUrl;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class UrlShortenerService
{
    private EntityManagerInterface $manager;
    private ContainerBagInterface $containerBag;

    public function __construct(
        EntityManagerInterface $manager,
        ContainerBagInterface $containerBag
    ) {
        $this->manager = $manager;
        $this->containerBag = $containerBag;
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

    public function generateHref(ShortUrl $url): string
    {
        return $this->containerBag->get('base.url') . $url->getCode();
    }
}
