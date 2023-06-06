<?php

namespace Flasher\Pnotify\Prime;

use Flasher\Prime\Plugin\Plugin;

class PnotifyPlugin extends Plugin
{
    public function getScripts()
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

    public function getStyles()
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
