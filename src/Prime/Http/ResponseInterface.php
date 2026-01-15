<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

interface ResponseInterface
{
    public function isRedirection(): bool;

    public function isJson(): bool;

    public function isHtml(): bool;

    public function isAttachment(): bool;

    public function isSuccessful(): bool;

    public function getContent(): string;

    public function setContent(string $content): void;

    public function hasHeader(string $key): bool;

    public function getHeader(string $key): ?string;

    /**
     * @param string|string[]|null $values
     */
    public function setHeader(string $key, string|array|null $values): void;

    public function removeHeader(string $key): void;
}
