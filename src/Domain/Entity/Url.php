<?php

namespace App\Domain\Entity;

class Url
{
    private string $value;

    public function __construct(?string $value)
    {
        $this->assertValidName($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidName(?string $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('Should be valid url');
        }
    }
}
