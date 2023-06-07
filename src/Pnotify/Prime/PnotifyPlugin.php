<?php

declare(strict_types=1);

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Plugin\Plugin;

final class PnotifyPlugin extends Plugin
{
    /**
     * @return array{cdn: string[], local: string[]}
     */
    public function getScripts(): array
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-pnotify@1.3.1/dist/flasher-pnotify.min.js',
            ],
            'local' => [
                '/vendor/flasher/flasher-pnotify.min.js',
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
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-pnotify@1.3.1/dist/flasher-pnotify.min.css',
            ],
            'local' => [
                '/vendor/flasher/flasher-pnotify.min.css',
            ],
        ];
    }
}
