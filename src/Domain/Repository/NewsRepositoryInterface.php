<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    /**
     * @return News[]
     */
    public function findAll(): iterable;

    /**
     * @return News[]
     */
    public function findByIds(iterable $ids): iterable;

    /**
     * @param News $news
     * @return void
     */
    public function save(News $news): void;
}
