<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Title;

class News
{
    private ?int $id = null;

    public function __construct(
        private Url  $url,
        private Title $title,
        private \DateTime $created_at = new \DateTime()
    ){

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

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }
}
