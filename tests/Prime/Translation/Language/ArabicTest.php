<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation\Language;

use Flasher\Prime\Translation\Language\Arabic;
use PHPUnit\Framework\TestCase;

final class ArabicTest extends TestCase
{
    /**
     * Function to test the translations method of the Arabic class.
     */
    public function testTranslations(): void
    {
        $expectedTranslations = [
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

        $this->assertSame($expectedTranslations, Arabic::translations());
    }
}
