<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Domain\Generator\Url;

class UrlGatewayRequest
{

    /**
     * @param string $url
     */
    public function __construct(
        public string $url
    ) {
    }
}
