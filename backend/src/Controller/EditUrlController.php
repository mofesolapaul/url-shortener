<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\ApiCallException;
use App\Form\EditShortUrlType;
use App\Service\ErrorService;
use App\UseCase\EditShortUrlUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditUrlController extends AbstractController
{
    private EditShortUrlUseCase $useCase;

    public function __construct(EditShortUrlUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    #[Route('/api/customize', name: 'api_customize', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(EditShortUrlType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $shortUrl = $this->useCase->execute($form->getData());

            if (!$shortUrl) {
                return new JsonResponse([
                    'error' => 'This custom url is already taken.'
                ], 400);
            }

            return new JsonResponse(compact('shortUrl'));
        }

        throw new ApiCallException(ErrorService::getFirstError($form));
    }
}
