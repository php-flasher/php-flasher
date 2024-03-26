<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class Arabic
{
    /**
     * Arabic translations.
     *
     * @return array<string, string> array of message keys and their Arabic translations
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
