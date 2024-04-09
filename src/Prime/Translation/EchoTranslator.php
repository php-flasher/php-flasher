<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

/**
 * In this implementation, it simply returns the identifier as is, without performing any actual translation.
 */
final readonly class EchoTranslator implements TranslatorInterface
{
    public function translate(string $id, array $parameters = [], ?string $locale = null): string
    {
        return $id;
    }

    public function getLocale(): string
    {
        return 'en';
    }
}
