<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

/**
 * Spanish - Provides Spanish translations for common notification messages.
 *
 * This class contains translations of common notification messages and terms
 * in Spanish. It's part of PHPFlasher's built-in translation system that
 * provides translations without requiring an external translation service.
 *
 * Design patterns:
 * - Data Transfer Object: Provides a structured set of translations
 * - Static Provider: Offers static access to translation data
 */
final readonly class Spanish
{
    /**
     * Provides Spanish translations for common notification messages.
     *
     * The returned array maps message identifiers to their Spanish translations.
     * It includes basic notification types and common resource action messages.
     * Uses the ':resource' placeholder for variable substitution.
     *
     * Note: Spanish has grammatical gender, so these translations assume masculine
     * form with "El" article, which works for "recurso" (resource).
     *
     * @return array<string, string> Mapping of message identifiers to translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'Éxito',
            'error' => 'Error',
            'warning' => 'Advertencia',
            'info' => 'Información',

            'The resource was created' => 'El :resource fue creado',
            'The resource was updated' => 'El :resource fue actualizado',
            'The resource was saved' => 'El :resource fue guardado',
            'The resource was deleted' => 'El :resource fue eliminado',

            'resource' => 'recurso',
        ];
    }
}
