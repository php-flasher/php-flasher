<?php

return [
    'scripts' => [
        'cdn' => [
            'https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js',
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.3.1/dist/flasher-toastr.min.js',
        ],
        'local' => [
            '/vendor/flasher/jquery.min.js',
            '/vendor/flasher/flasher-toastr.min.js',
        ],
    ],
    'styles' => [
        'cdn' => [
            'https://cdn.jsdelivr.net/npm/@flasher/flasher-toastr@1.3.1/dist/flasher-toastr.min.css',
        ],
        'local' => [
            '/vendor/flasher/flasher-toastr.min.css',
        ],
    ],
];
