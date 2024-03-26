<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class German
{
    /**
     * German translations.
     *
     * @return array<string, string> array of message keys and their German translations
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
