<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class Spanish
{
    /**
     * Spanish translations.
     *
     * @return array<string, string> array of message keys and their Spanish translations
     */
    public static function translations(): array
    {
        return [
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
    }
}
