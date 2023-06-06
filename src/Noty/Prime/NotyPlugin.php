<?php

namespace Flasher\Noty\Prime;

use Flasher\Prime\Plugin\Plugin;

class NotyPlugin extends Plugin
{
    public function getScripts()
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

    public function getStyles()
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
