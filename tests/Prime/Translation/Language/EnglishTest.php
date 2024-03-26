<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation\Language;

use Flasher\Prime\Translation\Language\English;
use PHPUnit\Framework\TestCase;

final class EnglishTest extends TestCase
{
    /**
     * Function to test the translations method of the English class.
     */
    public function testTranslations(): void
    {
        $expectedTranslations = [
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

        $this->assertSame($expectedTranslations, English::translations());
    }
}
