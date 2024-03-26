<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation\Language;

use Flasher\Prime\Translation\Language\German;
use PHPUnit\Framework\TestCase;

final class GermanTest extends TestCase
{
    /**
     * Function to test the translations method of the German class.
     */
    public function testTranslations(): void
    {
        $expectedTranslations = [
            'success' => 'Erfolg',
            'error' => 'Fehler',
            'warning' => 'Warnung',
            'info' => 'Info',

            'The resource was created' => 'Die Ressource :resource wurde erstellt',
            'The resource was updated' => 'Die Ressource :resource wurde aktualisiert',
            'The resource was saved' => 'Die Ressource :resource wurde gespeichert',
            'The resource was deleted' => 'Die Ressource :resource wurde gelöscht',

            'resource' => 'Ressource',
        ];

        $this->assertSame($expectedTranslations, German::translations());
    }
}
