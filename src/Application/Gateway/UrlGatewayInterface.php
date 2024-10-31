<?php

declare(strict_types=1);

namespace App\Application\Gateway;

interface UrlGatewayInterface
{
    public function visitLink(UrlGatewayRequest $request): UrlGatewayResponse;
}