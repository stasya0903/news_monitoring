<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Report;

interface ReportRepositoryInterface
{
    /**
     * @param Report $report
     * @return void
     */
    public function save(Report $report): void;

}