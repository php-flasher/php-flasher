<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

/**
 * EchoTranslator - Minimal translator implementation that returns message IDs unchanged.
 *
 * This implementation simply returns the message identifiers as-is, without
 * performing any actual translation. It serves as a fallback translator when
 * no real translation service is available.
 *
 * Design patterns:
 * - Null Object: Provides a do-nothing implementation that maintains API compatibility
 * - Fallback: Serves as a default implementation when no specific translator is provided
 */
final readonly class EchoTranslator implements TranslatorInterface
{
    /**
     * {@inheritdoc}
     *
     * This implementation simply returns the message identifier unchanged.
     */
    public function translate(string $id, array $parameters = [], ?string $locale = null): string
    {
        return $id;
    }

    /**
     * {@inheritdoc}
     *
     * This implementation always returns 'en' as the default locale.
     */
    public function getLocale(): string
    {
        return 'en';
    }
}
