<?php

namespace Flasher\Toastr\Prime;

use Flasher\Prime\Plugin\Plugin;

class ToastrPlugin extends Plugin
{
    public function getScripts()
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js',
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.3.1/dist/flasher-toastr.min.js',
            ],
            'local' => [
                '/vendor/flasher/jquery.min.js',
                '/vendor/flasher/flasher-toastr.min.js',
            ],
        ];
    }

    public function getStyles()
    {
        return [
            'cdn' => [
                'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.3.1/dist/flasher-toastr.min.css',
            ],
            'local' => [
                '/vendor/flasher/flasher-toastr.min.css',
            ],
        ];
    }
}
