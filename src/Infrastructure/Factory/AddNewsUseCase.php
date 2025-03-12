<?php

namespace App\Infrastructure\Factory;

use App\Application\Command\CreateNewsCommand;
use App\Application\Command\CreateNewsHandler;
use App\Application\Gateway\UrlGatewayInterface;
use App\Application\Gateway\UrlGatewayRequest;
use App\Application\UseCase\AddNews\AddNewsRequest;
use App\Application\UseCase\AddNews\AddNewsResponse;

class AddNewsUseCase
{
    public function __construct(

        private readonly  CreateNewsHandler $createNewsHandler,
        private readonly UrlGatewayInterface $urlGateway,

    ) {
    }
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $urlGatewayRequest = new UrlGatewayRequest($request->url);
        $urlGatewayResponse = $this->urlGateway->visitLink($urlGatewayRequest);
        $command = new CreateNewsCommand($request->url, $urlGatewayResponse->title);
        $news = $this->createNewsHandler->handle($command);
        return new AddNewsResponse($news->getId());
    }
}
