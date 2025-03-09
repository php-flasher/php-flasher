<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

/**
 * Russian - Provides Russian translations for common notification messages.
 *
 * This class contains translations of common notification messages and terms
 * in Russian. It's part of PHPFlasher's built-in translation system that
 * provides translations without requiring an external translation service.
 *
 * Design patterns:
 * - Data Transfer Object: Provides a structured set of translations
 * - Static Provider: Offers static access to translation data
 */
final readonly class Russian
{
    /**
     * Provides Russian translations for common notification messages.
     *
     * The returned array maps message identifiers to their Russian translations.
     * It includes basic notification types and common resource action messages.
     * Uses the ':resource' placeholder for variable substitution.
     *
     * Note: Russian translations have gender-specific grammar, assuming masculine
     * form for the placeholder.
     *
     * @return array<string, string> Mapping of message identifiers to translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'Успех',
            'error' => 'Ошибка',
            'warning' => 'Предупреждение',
            'info' => 'Информация',

            'The resource was created' => ':resource был создан',
            'The resource was updated' => ':resource был обновлен',
            'The resource was saved' => ':resource был сохранен',
            'The resource was deleted' => ':resource был удален',

            'resource' => 'ресурс',
        ];
    }
}
