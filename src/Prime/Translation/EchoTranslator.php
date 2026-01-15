<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

final readonly class EchoTranslator implements TranslatorInterface
{
    /**
     * @param array<string, mixed> $parameters
     */
    public function translate(string $id, array $parameters = [], ?string $locale = null): string
    {
        return $id;
    }

    public function getLocale(): string
    {
        return 'en';
    }
}
