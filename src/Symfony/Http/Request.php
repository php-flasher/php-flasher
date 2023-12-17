<?php

declare(strict_types=1);

namespace Flasher\Symfony\Http;

use Flasher\Prime\Http\RequestInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

        $flashBag = $session->getFlashBag();

        return $flashBag->has($type);
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

        $flashBag = $session->getFlashBag();

        return $flashBag->get($type);
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
}
