<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Report;
use App\Domain\Repository\ReportRepositoryInterface;
use App\Infrastructure\Exceptions\FileSaveException;
use Symfony\Component\Filesystem\Filesystem;

class FileReportRepository implements ReportRepositoryInterface
{
    /**
     * @param Filesystem $filesystem
     */
    public function __construct(
        private readonly Filesystem $filesystem
    ) {
    }

    /**
     * @param Report $report
     * @return void
     * @throws FileSaveException
     */
    public function save(Report $report): void
    {
        try {
            //TODO directory to env?
            $this->filesystem->mkdir('reports');
            $currentTimeStamp = (new \DateTimeImmutable())->getTimestamp();
            $fileLink = "reports/report_$currentTimeStamp.html";
            $this->filesystem->dumpFile($fileLink, $report->getContent()->getValue());
            $reflectionProperty = new \ReflectionProperty(Report::class, 'link');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($report, $fileLink);
        } catch (\Exception $exception) {
            throw new FileSaveException('Error while saving report file:' . $exception->getMessage());
        }
    }
}
