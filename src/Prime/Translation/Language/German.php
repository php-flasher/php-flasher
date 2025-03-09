<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

/**
 * German - Provides German translations for common notification messages.
 *
 * This class contains translations of common notification messages and terms
 * in German. It's part of PHPFlasher's built-in translation system that
 * provides translations without requiring an external translation service.
 *
 * Design patterns:
 * - Data Transfer Object: Provides a structured set of translations
 * - Static Provider: Offers static access to translation data
 */
final readonly class German
{
    /**
     * Provides German translations for common notification messages.
     *
     * The returned array maps message identifiers to their German translations.
     * It includes basic notification types and common resource action messages.
     * Uses the ':resource' placeholder for variable substitution.
     *
     * Note: German has different grammatical structures, so the translations
     * include the full phrase "Die Ressource" rather than just inserting the placeholder.
     *
     * @return array<string, string> Mapping of message identifiers to translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'Erfolg',
            'error' => 'Fehler',
            'warning' => 'Warnung',
            'info' => 'Info',

            'The resource was created' => 'Die Ressource :resource wurde erstellt',
            'The resource was updated' => 'Die Ressource :resource wurde aktualisiert',
            'The resource was saved' => 'Die Ressource :resource wurde gespeichert',
            'The resource was deleted' => 'Die Ressource :resource wurde gelöscht',

            'resource' => 'Ressource',
        ];
    }
}
