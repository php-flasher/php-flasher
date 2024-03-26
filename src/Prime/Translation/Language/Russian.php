<?php

declare(strict_types=1);

namespace Flasher\Prime\Translation\Language;

final readonly class Russian
{
    /**
     * Russian translations.
     *
     * @return array<string, string> array of message keys and their Russian translations
     */
    public static function translations(): array
    {
        return [
            'success' => 'Успех',
            'error' => 'Ошибка',
            'warning' => 'Предупреждение',
            'info' => 'Информация',

            'The resource was created' => ':resource был создан',
            'The resource was updated' => ':resource был обновлен',
            'The resource was saved' => ':resource был сохранен',
            'The resource was deleted' => ':resource был удален',

            'resource' => 'ресурс',
        ];
    }
}
