<?php

namespace App\Application\UseCase\AddNews;

use App\Application\Gateway\UrlGatewayInterface;
use App\Application\Gateway\UrlGatewayRequest;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Generator\Url;
use App\Domain\Repository\NewsRepositoryInterface;

class AddNewsUseCase
{
    public function __construct(
        private readonly NewsFactoryInterface $newsFactory,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly UrlGatewayInterface $urlGateway,
    ) {
    }
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $url = new Url($request->url);
        $urlGatewayRequest = new UrlGatewayRequest($request->url);
        $urlGatewayResponse = $this->urlGateway->visitLink($urlGatewayRequest);
        $news = $this->newsFactory->create($url, $urlGatewayResponse->title);
        $this->newsRepository->save($news);
        return new AddNewsResponse($news->getId());
    }
}
