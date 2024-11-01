<?php

namespace App\Application\UseCase\getReport;

use App\Domain\Generator\ReportGeneratorInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\ReportRepositoryInterface;

class GetReportUseCase
{
    public function __construct(
        private readonly ReportRepositoryInterface $reportRepository,
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly ReportGeneratorInterface $reportGenerator
    ) {

    }

    public function __invoke(GetReportRequest $request): GetReportResponse
    {
        $news = $this->newsRepository->findByIds($request->ids);
        $report = $this->reportGenerator->generate($news);
        $this->reportRepository->save($report);
        return new GetReportResponse($report->getLink());
    }
}
