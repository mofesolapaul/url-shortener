<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\SearchHistory;
use App\Entity\ShortUrl;
use App\Entity\UrlLog;
use App\Message\UrlLogMessage;
use App\Model\SearchData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UrlLogService
{
    private EntityManagerInterface $manager;
    private MessageBusInterface $messageBus;

    public function __construct(
        EntityManagerInterface $manager,
        MessageBusInterface $messageBus
    ) {
        $this->manager = $manager;
        $this->messageBus = $messageBus;
    }

    public function record(UrlLogMessage $logMessage): void
    {
        $repo = $this->manager->getRepository(ShortUrl::class);
        $shortUrl = $repo->findOneBy(['code' => $logMessage->getShortCode()]);
        if (!$shortUrl) {
            return;
        }

        $history = (new UrlLog())
            ->setUrlId($shortUrl->getId())
            ->setAccessTime($logMessage->getAccessTime());
        $this->manager->persist($history);
        $this->manager->flush();
    }

    public function queueAccessLog(string $code): void
    {
        $this->messageBus->dispatch(new UrlLogMessage($code, new \DateTime()));
    }
}
