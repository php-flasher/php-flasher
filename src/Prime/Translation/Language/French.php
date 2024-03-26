<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class French
{
    /**
     * French translations.
     *
     * @return array<string, string> array of message keys and their French translations
     */
    public static function translations(): array
    {
        return [
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
    }
}
