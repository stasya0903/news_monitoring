<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Entity\News;
use App\Domain\Entity\Url;
use App\Domain\ValueObject\Title;

interface NewsFactoryInterface
{
    /**
     * @param Url $url
     * @param Title $title
     * @return News
     */
    public function create(Url $url, Title $title): News;
}
