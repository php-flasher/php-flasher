<?php

/*
 * This file is part of the PHPFlasher package.
 * (c) Younes KHOUBZA <younes.khoubza@gmail.com>
 */

namespace Flasher\Laravel\Http;

use Flasher\Prime\Http\RequestInterface;
use Illuminate\Http\Request as LaravelRequest;

final class Request implements RequestInterface
{
    /**
     * @var LaravelRequest
     */
    private $request;

    public function __construct(LaravelRequest $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function isXmlHttpRequest()
    {
        return $this->request->ajax();
    }

    /**
     * {@inheritDoc}
     */
    public function isHtmlRequestFormat()
    {
        return 'html' === $this->request->getRequestFormat();
    }

    /**
     * {@inheritDoc}
     */
    public function hasSession()
    {
        return $this->request->hasSession();
    }

    /**
     * {@inheritDoc}
     */
    public function hasType($type)
    {
        $session = $this->request->session();

        return $session->has($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getType($type)
    {
        $session = $this->request->session();

        return $session->get($type); // @phpstan-ignore-line
    }

    /**
     * {@inheritDoc}
     */
    public function forgetType($type)
    {
        $session = $this->request->session();

        $session->forget($type);
    }
}
