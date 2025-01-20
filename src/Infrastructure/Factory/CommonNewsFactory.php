<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\News;
use App\Domain\Entity\Url;
use App\Domain\Factory\NewsFactoryInterface;
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
