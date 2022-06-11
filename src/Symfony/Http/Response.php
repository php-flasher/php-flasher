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
    public function getContent()
    {
        return $this->response->getContent();
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content)
    {
        $this->response->setContent($content);
    }
}
