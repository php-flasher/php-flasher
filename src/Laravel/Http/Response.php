<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

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

    /**
     * {@inheritDoc}
     */
    public function isRedirection()
    {
        return $this->response->isRedirection();
    }

    /**
     * {@inheritDoc}
     */
    public function isJson()
    {
        return $this->response instanceof LaravelJsonResponse;
    }

    /**
     * {@inheritDoc}
     */
    public function isHtml()
    {
        $contentType = $this->response->headers->get('Content-Type');

        return false !== stripos($contentType, 'html'); // @phpstan-ignore-line
    }

    /**
     * {@inheritDoc}
     */
    public function isAttachment()
    {
        $contentDisposition = $this->response->headers->get('Content-Disposition', '');

        return false !== stripos($contentDisposition, 'attachment;'); // @phpstan-ignore-line
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->response->getContent(); // @phpstan-ignore-line
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content)
    {
        $this->response->setContent($content);
    }
}
