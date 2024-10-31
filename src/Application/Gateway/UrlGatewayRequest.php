<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\ValueObject\Url;

class UrlGatewayRequest
{
    public function __construct(
        public readonly Url $url
    )
    {
    }
}