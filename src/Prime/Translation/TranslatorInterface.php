<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

interface TranslatorInterface
{
    /**
     * @param array<string, mixed> $parameters
     */
    public function translate(string $id, array $parameters = [], ?string $locale = null): string;

    public function getLocale(): string;
}
