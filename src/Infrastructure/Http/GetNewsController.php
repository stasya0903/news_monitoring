<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetList\GetListUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/api/v1/news/list',
    name: 'news_list',
    methods: ['GET']

)]
final class GetNewsController extends AbstractController
{
    public function __construct(
        private readonly GetListUseCase $useCase,
    )
    {
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        try {
            $response = ($this->useCase)();
            return $this->json(
                $response,
                200,
                [],
                ['json_encode_options' => JSON_UNESCAPED_UNICODE]
            );
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];

            return $this->json(
                $errorResponse,
                400,
                [],
                ['json_encode_options' => JSON_UNESCAPED_UNICODE]
            );
        }

    }
}
