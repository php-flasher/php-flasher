<?php

declare(strict_types=1);

namespace Flasher\Symfony\Http;

use Flasher\Prime\Http\RequestInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final readonly class Request implements RequestInterface
{
    public function __construct(private SymfonyRequest $request)
    {
    }

    public function getUri(): string
    {
        return $this->request->getRequestUri();
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

    public function isSessionStarted(): bool
    {
        $session = $this->getSession();

        return $session?->isStarted() ?: false;
    }

    public function hasType(string $type): bool
    {
        if (!$this->hasSession() || !$this->isSessionStarted()) {
            return false;
        }

        $session = $this->getSession();
        if (!$session instanceof FlashBagAwareSessionInterface) {
            return false;
        }

        return $session->getFlashBag()->has($type);
    }

    /**
     * @return string[]
     */
    public function getType(string $type): array
    {
        $session = $this->getSession();
        if (!$session instanceof FlashBagAwareSessionInterface) {
            return [];
        }

        return $session->getFlashBag()->get($type);
    }

    public function forgetType(string $type): void
    {
        $this->getType($type);
    }

    private function getSession(): ?SessionInterface
    {
        try {
            return $this->request->getSession();
        } catch (SessionNotFoundException) {
            return null;
        }
    }

    public function hasHeader(string $key): bool
    {
        return $this->request->headers->has($key);
    }

    public function getHeader(string $key): ?string
    {
        return $this->request->headers->get($key);
    }
}
