<?php

declare(strict_types=1);

namespace Flasher\Laravel\Http;

use Flasher\Prime\Http\RequestInterface;
use Illuminate\Http\Request as LaravelRequest;

final class Request implements RequestInterface
{
    public function __construct(private readonly LaravelRequest $request)
    {
    }

    public function isXmlHttpRequest(): bool
    {
        return $this->request->ajax();
    }

    public function isHtmlRequestFormat(): bool
    {
        return 'html' === $this->request->getRequestFormat();
    }

    public function hasSession(): bool
    {
        return $this->request->hasSession();
    }

    public function hasType($type): bool
    {
        $session = $this->request->session();

        return $session->has($type);
    }

    public function getType($type): string|array
    {
        $session = $this->request->session();

        return $session->get($type); // @phpstan-ignore-line
    }

    public function forgetType($type): void
    {
        $session = $this->request->session();

        $session->forget($type);
    }
}
