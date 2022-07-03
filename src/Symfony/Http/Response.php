<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Symfony\Http;

use Flasher\Prime\Http\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

final class Response implements ResponseInterface
{
    /**
     * @var SymfonyResponse
     */
    private $response;

    public function __construct(SymfonyResponse $response)
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
        return $this->response instanceof JsonResponse;
    }

    /**
     * {@inheritDoc}
     */
    public function isHtml()
    {
        $contentType = $this->response->headers->get('Content-Type');

        if (!\is_string($contentType)) {
            return false;
        }

        return false !== stripos($contentType, 'html');
    }

    /**
     * {@inheritDoc}
     */
    public function isAttachment()
    {
        $contentDisposition = $this->response->headers->get('Content-Disposition', '');

        if (!\is_string($contentDisposition)) {
            return false;
        }

        return false !== stripos($contentDisposition, 'attachment;');
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        $content = $this->response->getContent();

        return \is_string($content) ? $content : '';
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content)
    {
        $this->response->setContent($content);
    }
}
