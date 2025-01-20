<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\News;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Generator\Url;
use App\Domain\ValueObject\Title;

class CommonNewsFactory implements NewsFactoryInterface
{
    public function create(
        Url $url,
        Title $title
    ): News {
        return new News(
            $url,
            $title,
        );
    }
}
