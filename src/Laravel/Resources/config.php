<?php

declare(strict_types=1);

namespace Flasher\Laravel\Resources;

return [
    // Default notification library (e.g., 'flasher', 'toastr', 'noty', etc.)
    'default' => 'flasher',

    // Path to the main JavaScript file of PHPFlasher
    'main_script' => '/vendor/flasher/flasher.min.js',

    // Path to the stylesheets for PHPFlasher notifications
    'styles' => [
        '/vendor/flasher/flasher.min.css',
    ],

    // Whether to translate PHPFlasher messages using Laravel's translation service
    'translate' => true,

    // Automatically inject PHPFlasher assets into HTML response
    'inject_assets' => true,

    // Configuration for the flash bag (converting Laravel flash messages)
    // Map Laravel session keys to PHPFlasher types
    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    // Filter criteria for notifications (e.g., limit number, types)
    'filter' => [
        'limit' => 5, // Limit the number of displayed notifications
    ],
];
