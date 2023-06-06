<?php

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

    public function isXmlHttpRequest()
    {
        return $this->request->ajax();
    }

    public function isHtmlRequestFormat()
    {
        return 'html' === $this->request->getRequestFormat();
    }

    public function hasSession()
    {
        return $this->request->hasSession();
    }

    public function hasType($type)
    {
        $session = $this->request->session();

        return $session->has($type);
    }

    public function getType($type)
    {
        $session = $this->request->session();

        return $session->get($type); // @phpstan-ignore-line
    }

    public function forgetType($type)
    {
        $session = $this->request->session();

        $session->forget($type);
    }
}
