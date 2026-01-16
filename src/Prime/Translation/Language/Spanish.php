<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class Spanish
{
    /**
     * @return array<string, string>
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
