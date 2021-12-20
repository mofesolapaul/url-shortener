<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\CreateShortUrlType;
use App\Form\SearchType;
use App\UseCase\CreateShortUrlUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShortenUrlController extends AbstractController
{
    private CreateShortUrlUseCase $useCase;

    public function __construct(CreateShortUrlUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    #[Route('/api/shorten', name: 'api_shorten', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CreateShortUrlType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $shortUrl = $this->useCase->execute($form->getData());

            return new JsonResponse(compact('shortUrl'));
        }

        return new JsonResponse(
            ['error' => 'Invalid data'],
            Response::HTTP_BAD_REQUEST
        );
    }
}
