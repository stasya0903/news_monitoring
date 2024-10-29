<?php

namespace App\Application\UseCase\AddNews;


use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;

class AddNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface    $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository
    )
    {
    }
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $news = $this->newsFactory->create($request->url);
        $this->newsRepository->save($news);
        return new AddNewsResponse($news->getId());
    }

}