<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation\Language;

use Flasher\Prime\Translation\Language\Spanish;
use PHPUnit\Framework\TestCase;

final class SpanishTest extends TestCase
{
    /**
     * Function to test the translations method of the Spanish class.
     */
    public function testTranslations(): void
    {
        $expectedTranslations = [
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

        $this->assertSame($expectedTranslations, Spanish::translations());
    }
}
