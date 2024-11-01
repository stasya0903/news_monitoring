<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\AddNews\AddNewsRequest;
use App\Application\UseCase\AddNews\AddNewsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/v1/news/add',
    name: 'news_add',
    methods: ['POST']
)]
final class AddNewsController extends AbstractController
{
    public function __construct(
        private readonly AddNewsUseCase $useCase,
    ) {
    }

    /**
     * @param AddNewsRequest $request
     * @return Response
     */
    public function __invoke(#[MapRequestPayload] AddNewsRequest $request): Response
    {
        try {
            $response = ($this->useCase)($request);
            return $this->json($response);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            return $this->json($errorResponse, 400);
        }
    }
}
