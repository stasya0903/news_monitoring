<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateaway;

use App\Application\Gateway\UrlGatewayInterface;
use App\Application\Gateway\UrlGatewayRequest;
use App\Application\Gateway\UrlGatewayResponse;
use App\Domain\ValueObject\Title;
use DOMDocument;

class FollowUrlGateway implements UrlGatewayInterface
{
    /**
     * @param UrlGatewayRequest $request
     * @return UrlGatewayResponse
     */
    public function visitLink(UrlGatewayRequest $request): UrlGatewayResponse
    {
        $dom = $this->getDOM($request->url);
        $title = $this->getTitle($dom);
        return new UrlGatewayResponse(new Title($title));
    }

    /**
     * @param $url
     * @return DOMDocument
     */
    private function getDOM($url): DOMDocument
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTMLFile($url);
        return $dom;
    }

    /**
     * @param DOMDocument $dom
     * @return string
     */
    private function getTitle(DOMDocument $dom): string
    {
        $list = $dom->getElementsByTagName('title');
        return  $list->length ? $list->item(0)->textContent : '';
    }
}
