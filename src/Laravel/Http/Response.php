<?php

declare(strict_types=1);

namespace Flasher\Laravel\Http;

use Flasher\Prime\Http\ResponseInterface;
use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Illuminate\Http\Response as LaravelResponse;

final class Response implements ResponseInterface
{
    /**
     * @param  LaravelJsonResponse|LaravelResponse  $response
     */
    public function __construct(private $response)
    {
    }

    public function isRedirection()
    {
        return $this->response->isRedirection();
    }

    public function isJson()
    {
        return $this->response instanceof LaravelJsonResponse;
    }

    public function isHtml(): bool
    {
        $contentType = $this->response->headers->get('Content-Type');

        return false !== stripos($contentType, 'html'); // @phpstan-ignore-line
    }

    public function isAttachment(): bool
    {
        $contentDisposition = $this->response->headers->get('Content-Disposition', '');

        return false !== stripos($contentDisposition, 'attachment;'); // @phpstan-ignore-line
    }

    public function getContent()
    {
        return $this->response->getContent(); // @phpstan-ignore-line
    }

    public function setContent($content): void
    {
        $this->response->setContent($content);
    }
}
