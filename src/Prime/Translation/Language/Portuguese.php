<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

/**
 * Portuguese - Provides Portuguese translations for common notification messages.
 *
 * This class contains translations of common notification messages and terms
 * in Portuguese. It's part of PHPFlasher's built-in translation system that
 * provides translations without requiring an external translation service.
 *
 * Design patterns:
 * - Data Transfer Object: Provides a structured set of translations
 * - Static Provider: Offers static access to translation data
 */
final readonly class Portuguese
{
    /**
     * Provides Portuguese translations for common notification messages.
     *
     * The returned array maps message identifiers to their Portuguese translations.
     * It includes basic notification types and common resource action messages.
     * Uses the ':resource' placeholder for variable substitution.
     *
     * Note: Portuguese has grammatical gender, so these translations assume masculine
     * form with "O" article, which works for "recurso" (resource).
     *
     * @return array<string, string> Mapping of message identifiers to translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'Sucesso',
            'error' => 'Erro',
            'warning' => 'Aviso',
            'info' => 'Informação',

            'The resource was created' => 'O :resource foi criado',
            'The resource was updated' => 'O :resource foi atualizado',
            'The resource was saved' => 'O :resource foi salvo',
            'The resource was deleted' => 'O :resource foi deletado',

            'resource' => 'recurso',
        ];
    }
}
