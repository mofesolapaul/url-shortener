<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UrlLogMessage;
use App\Service\UrlLogService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UrlLogMessageHandler implements MessageHandlerInterface
{
    private UrlLogService $service;

    public function __construct(UrlLogService $service)
    {
        $this->service = $service;
    }

    public function __invoke(UrlLogMessage $message)
    {
        $this->service->record($message);
    }
}
