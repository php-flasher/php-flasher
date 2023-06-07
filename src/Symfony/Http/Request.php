<?php

declare(strict_types=1);

namespace Flasher\Symfony\Http;

use Flasher\Prime\Http\RequestInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Session\Session;

final class Request implements RequestInterface
{
    public function __construct(private readonly SymfonyRequest $request)
    {
    }

    public function isXmlHttpRequest(): bool
    {
        return $this->request->isXmlHttpRequest();
    }

    public function isHtmlRequestFormat(): bool
    {
        return 'html' === $this->request->getRequestFormat();
    }

    public function hasSession(): bool
    {
        return $this->request->hasSession();
    }

    public function hasType($type)
    {
        if (! $this->hasSession()) {
            return false;
        }

        $session = $this->request->getSession();
        if (! $session->isStarted()) {
            return false;
        }

        /** @var Session $session */
        $session = $this->request->getSession();
        $flashBag = $session->getFlashBag();

        return $flashBag->has($type);
    }

    public function getType($type): array
    {
        /** @var Session $session */
        $session = $this->request->getSession();
        $flashBag = $session->getFlashBag();

        return $flashBag->get($type);
    }

    public function forgetType($type): void
    {
        $this->getType($type);
    }
}
