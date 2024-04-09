<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class Portuguese
{
    /**
     * Portuguese translations.
     *
     * @return array<string, string> array of message keys and their Portuguese translations
     */
    public static function translations(): array
    {
        return [
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
    }
}
