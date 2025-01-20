<?php

namespace App\Domain\Entity;

use App\Domain\Generator\Url;
use App\Domain\ValueObject\Title;
use DateTimeImmutable;

class News
{
    private ?int $id = null;

    public function __construct(
        private Url $url,
        private Title $title,
        //TO DO immutable
        private DateTimeImmutable $created_at = new DateTimeImmutable()
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }
}
