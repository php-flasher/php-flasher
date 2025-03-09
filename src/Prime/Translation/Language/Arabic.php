<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

/**
 * Arabic - Provides Arabic translations for common notification messages.
 *
 * This class contains translations of common notification messages and terms
 * in Arabic. It's part of PHPFlasher's built-in translation system that
 * provides translations without requiring an external translation service.
 *
 * Arabic is a right-to-left (RTL) language and requires special handling for display.
 * The Language utility class handles RTL detection automatically.
 *
 * Design patterns:
 * - Data Transfer Object: Provides a structured set of translations
 * - Static Provider: Offers static access to translation data
 */
final readonly class Arabic
{
    /**
     * Provides Arabic translations for common notification messages.
     *
     * The returned array maps message identifiers to their Arabic translations.
     * It includes basic notification types and common resource action messages.
     * Uses the ':resource' placeholder for variable substitution.
     *
     * @return array<string, string> Mapping of message identifiers to translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'نجاح',
            'error' => 'خطأ',
            'warning' => 'تحذير',
            'info' => 'معلومة',

            'The resource was created' => 'تم إنشاء :resource',
            'The resource was updated' => 'تم تعديل :resource',
            'The resource was saved' => 'تم حفظ :resource',
            'The resource was deleted' => 'تم حذف :resource',

            'resource' => 'الملف',
        ];
    }
}
