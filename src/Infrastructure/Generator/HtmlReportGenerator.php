<?php

namespace App\Infrastructure\Generator;

use App\Application\Generator\ReportGeneratorInterface;
use App\Domain\Entity\News;
use App\Domain\Entity\Report;
use App\Domain\ValueObject\Content;
use App\Infrastructure\Exceptions\FileSaveException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Uid\Uuid;

// save file
class HtmlReportGenerator implements ReportGeneratorInterface
{
    /**
     * @param Filesystem $filesystem
     */
    public function __construct(
        private readonly Filesystem $filesystem
    ) {
    }

    /**
     * @param iterable $news
     * @return string
     * @throws FileSaveException
     */
    public function generate(iterable $news): Report
    {
        $data = '';
        foreach ($news as $item) {
            $data .= $this->addNewsToReport($item);
        };
        $report = new Report(new Content($this->addToHtmlPage($data)));
        $this->save($report);
        return $report;
    }
    /**
     * @param Report $report
     * @return void
     * @throws FileSaveException
     */
    public function save(Report $report): void
    {
        try {
            $this->filesystem->mkdir('reports');
            $fileName = $this->getFileName('reports');
            $fileLink = "reports/report_$fileName.html";
            $this->filesystem->dumpFile($fileLink, $report->getContent()->getValue());
            $reflectionProperty = new \ReflectionProperty(Report::class, 'link');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($report, $fileLink);
        } catch (\Exception $exception) {
            throw new FileSaveException('Error while saving report file:' . $exception->getMessage());
        }
    }

    /**
     * @param News $item
     * @return string
     */
    private function addNewsToReport(News $item): string
    {
        return sprintf(
            '
           <li> <a href="%s">%s</a></li>',
            $item->getUrl()->getValue(),
            $item->getTitle()->getValue()
        );
    }

    /**
     * @param string $data
     * @return string
     */
    private function addToHtmlPage(string $data): string
    {

        return "<!doctype html>
    <html>
      <head>
         <meta charset='utf-8'>
           <title>news report</title>
      </head>
      <body>
        <ul>$data
        </ul>
      </body>
    </html>";
    }

    private function getFileName($extension = 'html'): string
    {
        $uuid = Uuid::v4();
        return sprintf('%s.%s', $uuid, $extension);
    }
}
