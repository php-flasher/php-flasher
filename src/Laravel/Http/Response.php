<?php

namespace Flasher\Laravel\Http;

use Flasher\Prime\Http\ResponseInterface;
use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Illuminate\Http\Response as LaravelResponse;

final class Response implements ResponseInterface
{
    /**
     * @var LaravelJsonResponse|LaravelResponse
     */
    private $response;

    /**
     * @param LaravelJsonResponse|LaravelResponse $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function isRedirection()
    {
        return $this->response->isRedirection();
    }

    public function isJson()
    {
        return $this->response instanceof LaravelJsonResponse;
    }

    public function isHtml()
    {
        $contentType = $this->response->headers->get('Content-Type');

        return false !== stripos($contentType, 'html'); // @phpstan-ignore-line
    }

    public function isAttachment()
    {
        $contentDisposition = $this->response->headers->get('Content-Disposition', '');

        return false !== stripos($contentDisposition, 'attachment;'); // @phpstan-ignore-line
    }

    public function getContent()
    {
        return $this->response->getContent(); // @phpstan-ignore-line
    }

    public function setContent($content)
    {
        $this->response->setContent($content);
    }
}
