<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

/**
 * French - Provides French translations for common notification messages.
 *
 * This class contains translations of common notification messages and terms
 * in French. It's part of PHPFlasher's built-in translation system that
 * provides translations without requiring an external translation service.
 *
 * Design patterns:
 * - Data Transfer Object: Provides a structured set of translations
 * - Static Provider: Offers static access to translation data
 */
final readonly class French
{
    /**
     * Provides French translations for common notification messages.
     *
     * The returned array maps message identifiers to their French translations.
     * It includes basic notification types and common resource action messages.
     * Uses the ':resource' placeholder for variable substitution.
     *
     * @return array<string, string> Mapping of message identifiers to translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'Succès',
            'error' => 'Erreur',
            'warning' => 'Avertissement',
            'info' => 'Information',

            'The resource was created' => 'La ressource :resource a été ajoutée',
            'The resource was updated' => 'La ressource :resource a été mise à jour',
            'The resource was saved' => 'La ressource :resource a été enregistrée',
            'The resource was deleted' => 'La ressource :resource a été supprimée',

            'resource' => '',
        ];
    }
}
