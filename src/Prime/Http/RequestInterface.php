<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

/**
 * @method string getUri()
 */
interface RequestInterface
{
    // public function getUri(): string;

    public function isXmlHttpRequest(): bool;

    public function isHtmlRequestFormat(): bool;

    public function hasSession(): bool;

    public function isSessionStarted(): bool;

    public function hasType(string $type): bool;

    /**
     * @return string|string[]
     */
    public function getType(string $type): string|array;

    public function forgetType(string $type): void;

    public function hasHeader(string $key): bool;

    public function getHeader(string $key): ?string;
}
