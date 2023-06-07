<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

final class EchoTranslator implements TranslatorInterface
{
    public function translate(string $id, array $parameters = [], string $locale = null): string
    {
        return $id;
    }

    public function getLocale(): string
    {
        return 'en';
    }
}
