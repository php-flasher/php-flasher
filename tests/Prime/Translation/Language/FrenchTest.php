<?php

declare(strict_types=1);

namespace Flasher\Tests\Prime\Translation\Language;

use Flasher\Prime\Translation\Language\French;
use PHPUnit\Framework\TestCase;

final class FrenchTest extends TestCase
{
    /**
     * Function to test the translations method of the French class.
     */
    public function testTranslations(): void
    {
        $expectedTranslations = [
            'success' => 'Succès',
            'error' => 'Erreur',
            'warning' => 'Avertissement',
            'info' => 'Information',

            'The resource was created' => 'La ressource :resource a été ajoutée',
            'The resource was updated' => 'La ressource :resource a été mise à jour',
            'The resource was saved' => 'La ressource :resource a été enregistrée',
            'The resource was deleted' => 'La ressource :resource a été supprimée',

            'resource' => '',
        ];

        $this->assertSame($expectedTranslations, French::translations());
    }
}
