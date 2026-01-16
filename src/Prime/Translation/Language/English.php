<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class English
{
    /**
     * @return array<string, string>
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
