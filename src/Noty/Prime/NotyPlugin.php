<?php

declare(strict_types=1);

namespace Flasher\Noty\Prime;

use Flasher\Prime\Plugin\Plugin;

final class NotyPlugin extends Plugin
{
    /**
     * @return array{cdn: string[], local: string[]}
     */
    public function getScripts(): array
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@1.3.1/dist/flasher-noty.min.js',
            ],
            'local' => [
                '/vendor/flasher/flasher-noty.min.js',
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
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-noty@1.3.1/dist/flasher-noty.min.css',
            ],
            'local' => [
                '/vendor/flasher/flasher-noty.min.css',
            ],
        ];
    }
}
