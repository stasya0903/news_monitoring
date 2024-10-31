<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\News;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class CommonNewsFactory implements NewsFactoryInterface
{

    public function create(
        Url $url,
        Title $title
    ): News
    {
        return new News(
            $url,
            $title,
        );
    }
}