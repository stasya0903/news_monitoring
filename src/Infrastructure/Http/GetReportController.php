<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\getReport\GetReportRequest;
use App\Application\UseCase\getReport\GetReportUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/v1/news/report',
    name: 'news_report',
    methods: ['POST']
)]
final class GetReportController extends AbstractController
{
    public function __construct(
        private readonly GetReportUseCase $useCase,
    ) {
    }

    /**
     * @param GetReportRequest $request
     * @return Response
     */
    public function __invoke(#[MapRequestPayload] GetReportRequest $request): Response
    {
        try {
            $response = ($this->useCase)($request);
            return $this->json($response);
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            return $this->json($errorResponse, 400, [], ['json_encode_options' => JSON_UNESCAPED_UNICODE]);
        }
    }
}
