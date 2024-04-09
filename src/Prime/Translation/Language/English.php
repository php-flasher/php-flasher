<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class English
{
    /**
     * English translations.
     *
     * @return array<string, string> array of message keys and their English translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'Success',
            'error' => 'Error',
            'warning' => 'Warning',
            'info' => 'Info',

            'The resource was created' => 'The :resource was created',
            'The resource was updated' => 'The :resource was updated',
            'The resource was saved' => 'The :resource was saved',
            'The resource was deleted' => 'The :resource was deleted',

            'resource' => 'resource',
        ];
    }
}
