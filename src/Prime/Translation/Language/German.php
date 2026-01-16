<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class German
{
    /**
     * @return array<string, string>
     */
    public static function translations(): array
    {
        return [
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
    }
}
