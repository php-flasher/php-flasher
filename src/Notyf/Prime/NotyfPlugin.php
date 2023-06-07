<?php

declare(strict_types=1);

namespace Flasher\Notyf\Prime;

use Flasher\Prime\Plugin\Plugin;

final class NotyfPlugin extends Plugin
{
    /**
     * @return array{cdn: string[], local: string[]}
     */
    public function getScripts(): array
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.js',
            ],
            'local' => [
                '/vendor/flasher/flasher-notyf.min.js',
            ],
        ];
    }

    /**
     * @return array{cdn: string[], local: string[]}
     */
    public function getStyles(): array
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-notyf@1.3.1/dist/flasher-notyf.min.css',
            ],
            'local' => [
                '/vendor/flasher/flasher-notyf.min.css',
            ],
        ];
    }
}
