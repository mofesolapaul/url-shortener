<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\CacheService;
use App\UseCase\FetchShortUrlUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends AbstractController
{
    private CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function __invoke(string $code): RedirectResponse
    {
        $fullUrl = $this->cacheService->fetch($code);
        if ($fullUrl) {
            return new RedirectResponse($fullUrl);
        }

        return new RedirectResponse($this->getParameter('app.url'));
    }
}
