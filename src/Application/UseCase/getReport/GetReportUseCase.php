<?php

namespace App\Application\UseCase\getReport;

use App\Application\Generator\ReportGeneratorInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\ReportRepositoryInterface;

class GetReportUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $reportGenerator
    ) {
    }

    public function __invoke(GetReportRequest $request): GetReportResponse
    {
        $news = $this->newsRepository->findByIds($request->ids);
        $report = $this->reportGenerator->generate($news);
        return new GetReportResponse($report->getLink());
    }
}
