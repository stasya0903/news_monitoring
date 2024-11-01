<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\ValueObject\Url;

class UrlGatewayRequest
{
    /**
     * @param Url $url
     */
    public function __construct(
        public readonly Url $url
    ) {
    }
}
