<?php

namespace App\Application\UseCase\GetList;

use App\Application\DTO\GetListResponseDTO;
use App\Domain\Repository\NewsRepositoryInterface;

class GetListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    public function __invoke(): iterable
    {
        $news = $this->newsRepository->findByIds();
        return array_map(
            function ($item) {
                return new GetListResponseDto(
                    $item->getId(),
                    $item->getCreatedAt(),
                    $item->getUrl()->getValue(),
                    $item->getTitle()->getValue()
                );
            },
            $news
        );
    }
}
