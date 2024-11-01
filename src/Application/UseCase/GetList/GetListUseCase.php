<?php

namespace App\Application\UseCase\GetList;


use App\Application\Gateway\UrlGatewayInterface;
use App\Application\Gateway\UrlGatewayRequest;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Url;

class GetListUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,

    )
    {
    }
    public function __invoke(): GetListResponse
    {
        $news = $this->newsRepository->findByIds();
        $newsInfo = array_map(
            function($item){
                return [
                    'id' => $item->getId(),
                    'date' => $item->getCreatedAt(),
                    'url' => $item->getUrl()->getValue(),
                    'title' => $item->getTitle()->getValue()
                ];
            }, $news
        );
        return new GetListResponse($newsInfo);
    }

}