<?php

namespace App\Application\UseCase\getReport;


use App\Application\Gateway\UrlGatewayInterface;
use App\Application\Gateway\UrlGatewayRequest;
use App\Application\UseCase\AddNews\AddNewsRequest;
use App\Application\UseCase\AddNews\AddNewsResponse;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Generator\ReportGeneratorInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\ReportRepositoryInterface;
use App\Domain\ValueObject\Url;

class GetReportUseCase
{
    public function __construct(
        private readonly ReportRepositoryInterface $reportRepository,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $reportGenerator
    )
    {
    }
    public function __invoke(GetReportRequest $request): GetReportResponse
    {
        $news = $this->newsRepository->findByIds($request->ids);
        $report = $this->reportGenerator->generate($news);
        $this->reportRepository->save($report);
        return new GetReportResponse($report->getLink());
    }

}