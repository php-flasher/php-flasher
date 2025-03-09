<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation;

/**
 * TranslatorInterface - Contract for notification translation services.
 *
 * This interface defines the essential operations for translating notification
 * content. It supports parameter substitution and locale-specific translations.
 *
 * Design patterns:
 * - Strategy: Defines a family of translation algorithms that can be used interchangeably
 * - Adapter: Provides a common interface for different translation implementations
 */
interface TranslatorInterface
{
    /**
     * Translates a message identifier to the target locale.
     *
     * This method transforms a message identifier like 'success' or 'The resource was created'
     * into a localized string, substituting any parameters in the process.
     *
     * @param string               $id         The message identifier to translate
     * @param array<string, mixed> $parameters Parameters to substitute in the translated string
     * @param string|null          $locale     The target locale, or null to use the default
     *
     * @return string The translated string
     */
    public function translate(string $id, array $parameters = [], ?string $locale = null): string;

    /**
     * Gets the default locale used by the translator.
     *
     * @return string The default locale code (e.g., 'en', 'fr')
     */
    public function getLocale(): string;
}
