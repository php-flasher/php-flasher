<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

/**
 * English - Provides English translations for common notification messages.
 *
 * This class contains translations of common notification messages and terms
 * in English. It's part of PHPFlasher's built-in translation system that provides
 * translations without requiring an external translation service.
 *
 * Design patterns:
 * - Data Transfer Object: Provides a structured set of translations
 * - Static Provider: Offers static access to translation data
 */
final readonly class English
{
    /**
     * Provides English translations for common notification messages.
     *
     * The returned array maps message identifiers to their English translations.
     * It includes basic notification types and common resource action messages.
     *
     * @return array<string, string> Mapping of message identifiers to translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'Success',
            'error' => 'Error',
            'warning' => 'Warning',
            'info' => 'Info',

            'The resource was created' => 'The :resource was created',
            'The resource was updated' => 'The :resource was updated',
            'The resource was saved' => 'The :resource was saved',
            'The resource was deleted' => 'The :resource was deleted',

            'resource' => 'resource',
        ];
    }
}
