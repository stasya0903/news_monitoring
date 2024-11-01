<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Title;

class Report
{
    private string $link;
    public function __construct(
        private readonly Content $content,
    ){
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getContent(): Content
    {
        return $this->content;
    }
}
