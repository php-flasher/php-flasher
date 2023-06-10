<?php

declare(strict_types=1);

namespace Flasher\Prime\Http;

interface ResponseInterface
{
    public function isRedirection(): bool;

    public function isJson(): bool;

    public function isHtml(): bool;

    public function isAttachment(): bool;

    public function getContent(): string;

    public function setContent(string $content): void;
}
