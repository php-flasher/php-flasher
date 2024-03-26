<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation\Language;

use Flasher\Prime\Translation\Language\Russian;
use PHPUnit\Framework\TestCase;

final class RussianTest extends TestCase
{
    /**
     * Function to test the translations method of the Russian class.
     */
    public function testTranslations(): void
    {
        $expectedTranslations = [
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

        $this->assertSame($expectedTranslations, Russian::translations());
    }
}
