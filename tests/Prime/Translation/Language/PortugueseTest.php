<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation\Language;

use Flasher\Prime\Translation\Language\Portuguese;
use PHPUnit\Framework\TestCase;

final class PortugueseTest extends TestCase
{
    /**
     * Function to test the translations method of the Portuguese class.
     */
    public function testTranslations(): void
    {
        $expectedTranslations = [
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

        $this->assertSame($expectedTranslations, Portuguese::translations());
    }
}
