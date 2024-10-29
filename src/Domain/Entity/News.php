<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Url;

class News
{
    private ?int $id = null;
    private ?string $title = null;
    //todo typecast?
    private ?string $created_at = null;


    public function __construct(
        private Url  $url
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }

}