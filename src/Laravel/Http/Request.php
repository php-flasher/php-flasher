<?php

declare(strict_types=1);

namespace Flasher\Laravel\Http;

use Flasher\Prime\Http\RequestInterface;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request as LaravelRequest;

/**
 * Request - Adapter for Laravel HTTP requests.
 *
 * This adapter implements PHPFlasher's RequestInterface for Laravel HTTP requests,
 * providing a consistent interface for request inspection and session interaction
 * regardless of the underlying framework.
 *
 * Design patterns:
 * - Adapter: Adapts framework-specific request objects to PHPFlasher's interface
 * - Decorator: Adds PHPFlasher-specific functionality to request objects
 * - Composition: Uses composition to delegate to the underlying request object
 */
final readonly class Request implements RequestInterface
{
    /**
     * Creates a new Request adapter.
     *
     * @param LaravelRequest $request The underlying Laravel request object
     */
    public function __construct(private LaravelRequest $request)
    {
    }

    public function getUri(): string
    {
        return $this->request->getUri();
    }

    public function isXmlHttpRequest(): bool
    {
        return $this->request->ajax();
    }

    public function isHtmlRequestFormat(): bool
    {
        return $this->request->acceptsHtml();
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

        return $session?->has($type) ?: false;
    }

    public function getType(string $type): string|array
    {
        $session = $this->getSession();

        /** @var false|string|string[] $type */
        $type = $session?->get($type);

        if (!\is_string($type) && !\is_array($type)) {
            return [];
        }

        return $type;
    }

    public function forgetType(string $type): void
    {
        $session = $this->getSession();

        $session?->forget($type);
    }

    /**
     * Gets the session from the request, with graceful handling of missing sessions.
     *
     * @return Session|null The session or null if not available
     */
    private function getSession(): ?Session
    {
        try {
            return $this->request->session();
        } catch (\RuntimeException) {
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
