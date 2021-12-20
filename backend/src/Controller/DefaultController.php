<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\FetchShortUrlUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends AbstractController
{
    private FetchShortUrlUseCase $useCase;

    public function __construct(FetchShortUrlUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(string $code): RedirectResponse
    {
        $shortUrl = $this->useCase->execute($code);
        if ($shortUrl) {
            return new RedirectResponse($shortUrl->getFullUrl());
        }

        return new RedirectResponse($this->getParameter('app.url'));
    }
}
