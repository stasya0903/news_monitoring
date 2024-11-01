<?php

namespace App\Infrastructure\Generator;

use App\Domain\Entity\News;
use App\Domain\Entity\Report;
use App\Domain\Generator\ReportGeneratorInterface;
use App\Domain\ValueObject\Content;

class HtmlReportGenerator implements ReportGeneratorInterface
{

    /**
     * @param iterable $news
     * @return Report
     */
    public function generate(iterable $news): Report
    {
        $data = '';
        foreach ($news as $item) {
            $data .= $this->addNewsToReport($item);
        };
        return new Report(new Content($this->addToHtmlPage($data)));
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
}